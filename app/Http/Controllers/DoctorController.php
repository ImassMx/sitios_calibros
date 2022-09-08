<?php

namespace App\Http\Controllers;

use App\Models\Liga;
use App\Models\User;
use App\Models\Doctor;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\DoctorsExport;
use App\Mail\LigaDoctor;
use App\Mail\LigaPaciente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Stmt\TryCatch;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth-doctor.register');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre' => 'required',
            'apellidos' => 'required',
            'especialidad'=> 'required',
            'id_slug' => 'required'
        ],[
            'nombre.required' =>'Ingrese su nombre porfavor',
            'apellidos.required' => 'Ingrese sus apellidos por favor',
            'especialidad.required' =>'Elija la especialidad a la que pertenece',
            'id_slug.required' => 'La liga es invalida'
        ]); 
        
        $liga = Liga::where('id',$request->id_slug)->first();


        if($liga->estado === 1){
            $user = new User();
            $user->name = $request->nombre;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->celular = $request->celular;
            $user->save();

            $folio = mt_rand(10000,99999);

            Doctor::create([
                'user_id' => $user->id,
                'especialidad_id'=> $request->especialidad,
                'nombre' => $request->nombre,
                'liga_id'=> $request->id_slug,
                'apellidos' => $request->apellidos,
                'cp' => $request->postal,
                'folio' => $folio,
            ]);

            //ENVIO DE SMS AL DOCTOR
            $token = $this->smsGetToken();

            $datos = [];
            try {
              
                $dominio = $_SERVER['HTTP_HOST'];

                 $mensaje = htmlspecialchars("Ingrese a esta liga para poder compartir el libro ".$dominio.'/login/doctor?folio='.$folio." su número de registro es ".$folio);
              
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

            auth()->attempt($request->only('email', 'password'));

            return response()->json($folio);
        }else{
            return response()->json(1,500);
        }
        
    }

    public function exportDoctor()
    {
        return Excel::download(new DoctorsExport, 'Doctores.xlsx'); 
    }

    public function ValidarEmail(Request $request)
    {
       $user = DB::table('users')->where('email',$request->correo)->first();

       return response()->json($user);
    }

    public function ValidarPhone(Request $request)
    {
        $user = DB::table('users')->where('celular',$request->celular)->first();

       return response()->json($user);
    }


    public function viewDoctor()
    {
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
            $response = $client->request('POST', 'token',
                ['form_params' => $datos]);

            $data = json_decode(utf8_decode($response->getBody()->getContents()), true);

            return $data["access_token"];

        } catch (\Exception $e) {
            $error = ["error" => "No se puede obtener token " . $e->getMessage()];
            return $error;
        }
    }

    function smsEnvia($telefono,$folio)
    {

        $token = $this->smsGetToken();

            $datos = [];
            try {
                $dominio = $_SERVER['HTTP_HOST'];
              
                 $mensaje = htmlspecialchars("Ingresa a esta liga ".$dominio." para descargar el libro con el codigo ".$folio);
              
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

                $datos = User::where("celular","LIKE",$telefono)->first();

                if($datos->email !== "")
                Mail::to($datos->email)->send(new LigaPaciente($folio,$dominio));

               } catch (\Exception $e) {
                Log::info('Error' . $e->getMessage());
               }

            } catch (\Exception $e) {
                $error = ["error" => "No se puede conectar al sistema de envio SMS =>" . $e->getMessage()];
                $cliente = '';

                Log::info('error' . json_encode($error));
               
            }
    }
    public function zonaDoctor()
    {
        return view('auth-doctor.zonaDoctor');
    }


    public function ZonaLoginDoctor(Request $request)
    {
        if (!auth()->attempt($request->only(['email', 'password']), $request->remember)) {
            return back()->with('mensaje', 'El número de folio es incorrecto');
        }

        $doctor = Doctor::where('folio',$request->folio)->first();
        $user = User::find($doctor->user_id);

        $name = Str::slug($user->name, '-');

        return redirect()->route('zona.doctor',['users' => $name,'folio' => $request->folio]);
    }
}
