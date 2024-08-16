<?php

namespace App\Http\Controllers;

use App\Models\Liga;
use App\Models\User;
use App\Models\Doctor;
use GuzzleHttp\Client;
use App\Mail\LigaDoctor;
use App\Models\BookSale;
use App\Mail\LigaPaciente;
use App\Models\ClientBook;
use App\Mail\DoctorWelcome;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\DoctorsExport;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\DownloadReportClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\DonwloadController;

class DoctorController extends Controller
{
    private $uuid;

    public function index(){

        if(auth()->check()){
            return redirect()->route('marketplace.inicio');
        }
        return view('auth-doctor.register');
    }

    public function store(Request $request) {
        $this->uuid = Str::uuid();

        $validate =  Validator::make($request->all(), [
            'nombre' => 'required',
            'apellidos' => 'required',
            'especialidad' => 'required',
            'cedula' => 'required',
            'email' => 'email|unique:users,email',
            'postal' => 'required|exists:sepomex,d_codigo',
            'celular' => 'required|unique:users,celular',
        ], [
            'nombre.required' => 'Ingrese su nombre porfavor',
            'apellidos.required' => 'Ingrese sus apellidos por favor',
            'especialidad.required' => 'Elija la especialidad a la que pertenece',
            'cedula.required' => 'La cedula es requerida.',
            'postal.required' => 'El código postal es requerido.',
            'email.email' => 'Ingrese un email válido.',
            'email.unique' => 'El email ya se encuentra registrado.',
            'postal.exists' => 'El código postal no es válido.',
            'celular.unique' => 'El número ya se encuentra registado.',
            'celular.required' => 'El celular es requerido.',
        ]);
        $validate->validated();
        try {
      
                $user = new User();
                $user->name = $request->nombre;
                $user->email = $request->email;
                $user->password = Hash::make($this->uuid);
                $user->celular = $request->celular;
                $user->save();
    
                $folio = mt_rand(10000, 99999);

                Doctor::create([
                    'user_id' => $user->id,
                    'especialidad_id' => $request->especialidad,
                    'nombres' => $request->nombre,
                    'apellidos' => $request->apellidos,
                    'cp' => $request->postal,
                    'folio' => $folio,
                    'cedula'=>$request->cedula,
                    'uuid'=> $this->uuid
                ]);
    
                $dominio = $request->getSchemeAndHttpHost();
    
                Mail::to($request->email)
                    ->send(new DoctorWelcome($folio, $dominio));
    
                $token = $this->smsGetToken();
    
                $datos = [];
                try {
                    $mensaje = htmlspecialchars("Ingrese a esta liga para poder comprar los libros " . $dominio . '/login/doctor' . " su número de registro es " . $folio);
    
                    $liga = env("SMS_URL") . '/message';
    
                    $datos = [
                        'phones' => [$request->celular],
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
                } catch (\Exception $e) {
                    $error = ["error" => "No se puede conectar al sistema de envio SMS =>" . $e->getMessage()];
                    $cliente = '';
                    Log::info('error' . json_encode($error));
                }

                $request->merge(['password' => $this->uuid]);

                auth()->attempt($request->only('email', 'password'));
    
                return response()->json([
                    'error' => false,
                    'folio' => $folio,
                    'uuid' => $this->uuid
                ]);

        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                   "error" => "Hubo un error al registrar al doctor"
            ],500);
        }
    }

    public function exportDoctor(Request $request)
    {
        $startDate = $request->input('starDate');
        $endDate = $request->input('endDate');
        return Excel::download(new DoctorsExport($startDate,$endDate), 'Reporte Doctores.xlsx');
    }

    public function ValidarEmail(Request $request)
    {
        $user = DB::table('users')->where('email', $request->correo)->first();

        return response()->json($user);
    }

    public function ValidarPhone(Request $request)
    {
        $user = DB::table('users')->where('celular', $request->celular)->first();

        return response()->json($user);
    }


    public function viewDoctor()
    {
        if(auth()->check()){
            return redirect()->route('marketplace.inicio');
        }
        return view('auth-doctor.login');
    }

    function smsGetToken()
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

    function smsEnvia($telefono, $folio)
    {

        $token = $this->smsGetToken();

        $datos = [];
        try {
            $dominio = $_SERVER['HTTP_HOST'];

            $mensaje = htmlspecialchars("Ingresa a esta liga " . $dominio . " para descargar el libro con el codigo " . $folio);

            $liga = env("SMS_URL") . '/message';

            $datos = [
                'phones' => [$telefono],
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

            try {

                $datos = User::where("celular", "LIKE", $telefono)->first();

                if ($datos->email !== "")
                    Mail::to($datos->email)->send(new LigaPaciente($folio, $dominio));
            } catch (\Exception $e) {
                Log::info('Error' . $e->getMessage());
            }
        } catch (\Exception $e) {
            $error = ["error" => "No se puede conectar al sistema de envio SMS =>" . $e->getMessage()];
            $cliente = '';

            Log::info('error' . json_encode($error));
        }
    }

    public function donwloadBook(Request $request,$uuid){

        $book = BookSale::where('uuid',$uuid)->first();
        $book->downloads += 1;
        $book->save();
        
        $book_client = ClientBook::where('id',$request->client_books)->first();


        if(!empty($book)){

            $book_client->donwloads += 1;
            $book_client->save();

            DownloadReportClient::create([
                'client_id' => $book_client->cliente_id,
                'doctor_id' => $book_client->doctor_id,
                'book_sale_id' => $book_client->book_sale_id
            ]);

            $parsedUrl = parse_url($book->pdf);
            return Storage::disk('s3')->download($parsedUrl['path'],$book->name.'.pdf');
        }
    }
    
    public function zonaDoctor($uuid) {
        return view('auth-doctor.zonaDoctor',compact('uuid'));
    }

    public function ZonaLoginDoctor(Request $request)
    {
        $doctor = Doctor::where('folio',$request->folio)->first();
        
        if(empty($doctor)){
            return back()->with('mensaje', 'El número de folio no existe.');
        }

        $user = User::where('id',$doctor->user_id)->first();

        $request->merge(['email' => $user->email]);

        $request->merge(['password' => $doctor->uuid]);

        if (!Auth::attempt($request->only(['email', 'password']), true)) {
            return back()->with('mensaje', 'El número de folio es incorrecto');
        }

        return redirect()->route('zona.doctor',["uuid"=>$doctor->uuid]);
    }

    public function pacientesDoctor($uuid){
        return view('auth-doctor.pacientes',compact('uuid'));
    }

    public function editarDoctor($uuid){
        return view('auth-doctor.editarDoctor',compact('uuid'));
    }
}
