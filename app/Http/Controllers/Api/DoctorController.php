<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Doctor;
use GuzzleHttp\Client;
use App\Models\Cliente;
use App\Models\BookSale;
use App\Models\ClientBook;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PurchasedBook;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotificationPaciente;
use Illuminate\Support\Facades\Storage;
use Owenoj\PDFPasswordProtect\Facade\PDFPasswordProtect;


class DoctorController extends Controller
{
    private $messageMsm;
    private $dominio;

    public function informationDoctor($id){
        try {
            $doctor = Doctor::where('uuid',$id)->first();
            return response()->json([
                'doctor' => $doctor
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'error' => true,
                'message' => 'Hubo un error al traer la información del doctor'
            ],500);
        }
    }

    public function getBooksDoctor($id) {
        try {
            $doctor = Doctor::where('uuid',$id)->first();
            $books = PurchasedBook::where('user_id', $doctor->user_id)->with('book')->get();
            return response()->json($books);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'error' => true,
                'message' => 'Hubo un error al traer la de los libros'
            ],500);
        }
    }

    public function getInfoDoctor($id){
        try {
            $status = true;

            $doctor = Doctor::where('folio',$id)->first();

            if(!empty($doctor)){
                $status = false;
            }

            return response()->json([
                'error' => $status,
                'data' => $doctor
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function sendMessagePaciente(Request $request)
    {
        try {
            
            $this->dominio = $request->getSchemeAndHttpHost();

            $this->validateClient($request->phone,$request->book_id,$request->doctor);
            $token = $this->smsGetToken();
            try {

                $mensaje = htmlspecialchars($this->messageMsm);

                $liga = env("SMS_URL") . '/message';

                $datos = [
                    'phones' => [$request->phone],
                    'message' => $mensaje
                ];

                $headers = [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ];

                $options = [
                    'headers' => $headers,
                    'json' => $datos
                ];

                $client = new Client();

                Log::info('datos' . json_encode($datos));

                $rawResponse = $client->request('POST', $liga, $options)->getBody()->getContents();

                Log::info('response' . $rawResponse);
            } catch (\Exception $e) {
                $error = ["error" => "No se puede conectar al sistema de envio SMS =>" . $e->getMessage()];
                Log::info('error' . json_encode($error));
            }
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function sendEmailPaciente(Request $request){
        try {
            
            $user = User::where('email',$request->email)->first();

            if(!empty($user)){
                $client = Cliente::where('user_id',$user->id)->first();
                $doc = Doctor::where('uuid', $request->doctor)->first();
                $book = ClientBook::where('cliente_id',$client->id)
                        ->where('book_sale_id',$request->book_id)
                        ->where('doctor_id',$doc->id)
                        ->first();

                if(!empty($book)){
                    return response()->json([
                        'error' => true,
                        'message' => 'El cliente '. $user->name . ' ya tiene agregado este libro.'
                    ]);
                }
                
            }

            $dominio = $request->getSchemeAndHttpHost();
            
            Mail::to($request->email)
            ->send(new EmailNotificationPaciente($request->book_id,$request->doctor,$request->email,$dominio));
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function updateBook(Request $request ,$uuid){
        try {

            $book = BookSale::where('uuid',$uuid)->first();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $nameImage = 'books/' . Str::uuid() . "." . $image->extension();
                if (!empty($book->image)) {
                    $path_image = parse_url($book->image ?? '');
                    if (Storage::disk('s3')->exists($path_image['path'])) {
                        Storage::disk('s3')->delete($path_image['path']);
                    }
                }

                Storage::disk('s3')->put($nameImage, file_get_contents($image));
                $urlImage = config('filesystems.url_book').$nameImage;

            }

            if ($request->hasFile('pdf')) {
                $pdf = $request->file('pdf');
                $name = Str::uuid() . "." . $pdf->extension();
                $namePdf = 'pdf/' . $name;
                
                //CREAR PASSWORD
                $password = rand(1111111111, 9999999999);
            
                // Eliminar el PDF anterior si existe
                if (!empty($book->pdf)) {
                    $path_pdf = parse_url($book->pdf ?? '');
                    if (Storage::disk('s3')->exists($path_pdf['path'])) {
                        Storage::disk('s3')->delete($path_pdf['path']);
                    }
                }
            
                // Mover el nuevo PDF a la carpeta temporal
                $pdf->move(public_path('archivos'), $name);
            
                // Encriptar el PDF con contraseña
                PDFPasswordProtect::encrypt(public_path('archivos/' . $name), public_path('archivos/' . $name), $password);
            
                // Subir el PDF encriptado a S3
                Storage::disk('s3')->put($namePdf, file_get_contents(public_path('archivos/' . $name)));
                
                $file_path = public_path('archivos/' . $name);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                // Obtener la URL del PDF en S3
                $urlPdf = Storage::disk('s3')->url($namePdf);
            }

            $book->name = $request->name;
            $book->category_id = $request->category_id;
            $book->author = $request->author;
            $book->description = $request->description;
            $book->price = $request->price;
            $book->points = $request->points;
            $book->pdf = $request->hasFile('pdf') ? $urlPdf : $book->pdf;
            $book->image = $request->hasFile('image') ? $urlImage : $book->image;
            $book->password = $request->hasFile('pdf') ? $password : $book->password;
            $book->save();

            return response()->json([
                'error' => false,
                'message' => 'Se actualizó correctamente'
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ],500);
        }
    }


    private function validateClient($phone,$book,$doctor){
        try {
            $user = User::where('celular',$phone)->with('cliente')->first();
            $book = BookSale::where('id',$book)->first();
            $doc = Doctor::where('uuid',$doctor)->first();

            if(!empty($user)){
                $client_book = new ClientBook();
                $client_book->cliente_id = $user->cliente->id;
                $client_book->book_sale_id = $book->id;
                $client_book->doctor_id = $doc->id;
                $client_book->save();
                return $this->messageMsm = "Ingresa a esta liga ".$this->dominio."/login para que puedas descargar el libro ". $book->name. 
                " ingresando tu número de celular. \n La contraseña para leer el contenido del libro es : ". $book->password;
            }

            return $this->messageMsm = "Ingresa a esta liga ".$this->dominio."/registrar/paciente?book=".$book->uuid." 
            para que puedas descargar tu libro registrandote. \n La contraseña para leer el contenido del libro es : ". $book->password . " \n El número de folio es :".$doc->folio;

        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function getPacientesDoctor(Request $request ,$uuid){
        try {
            $filtro = $request->buscador;

            $doctor = Doctor::where('uuid',$uuid)->first();

            $books = ClientBook::where('doctor_id', $doctor->id)
            ->with(['book', 'client.user'])
            ->whereHas('book', function ($query) use ($filtro) {
                $query->where('name', 'LIKE', '%' . $filtro . '%');
            })
            ->orWhereHas('client.user', function ($query) use ($filtro) {
                $query->where('name', 'LIKE', '%' . $filtro . '%');
            })
            ->get();

            return response()->json([
                'error' => false,
                'data' => $books
            ]);

        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function deleteBook($id){
        try {
            ClientBook::where('id',$id)->delete();
            return response()->json([
                'error' => false,
                'message' => 'Se eliminó correctamente.'
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function getBook($uuid){
        try {
            $book = BookSale::where('uuid',$uuid)->first();
            return response()->json([
                'error' => false,
                'data' => $book
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    private function smsGetToken()
    {
        try {
            $liga = env("SMS_URL") . '/oauth/token';
            $datos = [
                'grant_type' => 'client_credentials',
                'client_id' => env("SMS_CLIENT"),
                'client_secret' => env("SMS_SECRET"),
                'scope' => '*'
            ];

            $client = new Client(['base_uri' => $liga]);
            $response = $client->request(
                'POST',
                'token',
                ['form_params' => $datos]
            );

            $data = json_decode(utf8_decode($response->getBody()->getContents()), true);

            return $data["access_token"];
        } catch (\Exception $e) {
            $error = ["error" => "No se puede obtener token " . $e->getMessage()];
            return $error;
        }
    }

    public function editarDoctor($uuid){
        try {
            $doctor = Doctor::where('uuid',$uuid)->with('user')->first();
            return response()->json($doctor);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function updateDoctor(Request $request , $uuid){
        try {
 
            $doctor = Doctor::where('uuid',$uuid)->first();
            $doctor->nombres = $request->nombre;
            $doctor->apellidos = $request->apellido;
            $doctor->cedula = $request->cedula;
            $doctor->save();
        
            $user = User::where('id',$doctor->user_id)->first();
            $user->name = $request->nombre;
            $user->celular = $request->celular;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Se actualizó correctamente la información.'
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
