<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Liga;
use App\Models\User;
use App\Models\Libro;
use App\Models\Doctor;
use App\Models\Estado;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Exports\ClientExport;
use Illuminate\Support\Facades\DB;
use Facade\FlareClient\Http\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class ClienteController extends Controller
{

    public function index()
    {
        return view('auth-cliente.login');
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'nombre_doctor' => 'required',
                'nombre_paciente' => 'required',
                'folio' => 'required',
                'email' => 'required|email|unique:users',
                'celular' => 'required|unique:users',
                'codigo' => 'required',
                'alcaldia' => 'required',
                'ciudad' => 'required',
                'estado' => 'required'
            ],
            [
                'nombre_doctor.required' => 'El nombre del doctor es requerido',
                'nombre_paciente.required' => 'El nombre del paciente es requerido',
                'folio.required' => 'El folio es requerido',
                'email.required' => 'El email es requerido',
                'email.email' => 'Ingrese un email válido',
                'email.unique' => 'Este email ya se encuentra registrado',
                'codigo.required' => 'El código postal es requerido',
                'celular.required' => 'Ingrese un número de celular ',
                'celular.unique' => 'El número de celular ya se encuentra registrado',
                'alcaldia.required' => 'La alcaldia o municipio es requerido',
                'ciudad.required' => 'La ciudad es requerida',
                'estado.required' => 'El estado es requerido',
            ]
        );
      
        try {

            $doctor = Doctor::where('folio', $request->folio)->with('ligas')->first();
            $libro_id = DB::table('publicacions')->where('liga_id',$doctor->liga_id)->get();

            if ($doctor->ligas->slug) {
                $usuario = User::create([
                    'name' => $request->nombre_paciente,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'celular' => $request->celular
                ])->assignRole('Cliente');

                $client =  Cliente::create([
                    'user_id' => $usuario->id,
                    'nombre_doctor' => $request->nombre_doctor,
                    'folio' => $request->folio,
                    'codigo_postal' => $request->codigo,
                    'alcaldia' => $request->alcaldia,
                    'ciudad' => $request->ciudad,
                    'estado' => $request->estado,
                    'libro_id'=> $libro_id[0]->libro_id,
                    'created_at' => date('d-m-Y')
                ]);

                auth()->attempt($request->only('email', 'password'));
                return redirect()->route('zona.descarga', $doctor->ligas->slug);
            }
        } catch (\Throwable $th) {
            return back()->with('mensaje', 'El número de folio es inválido');
        }
    }

    public function login(Request $request)
    {
        
        if (!auth()->attempt($request->only(['celular', 'password']), $request->remember)) {
            return back()->with('mensaje', 'El número de celular es incorrecto');
        }
        $cliente = User::where('celular',$request->celular)->with('cliente')->first();
        $libro =$cliente->cliente->libro_id;

        $libro_id = DB::table('publicacions')->where('libro_id',$libro)->first();
        $slug = Liga::where('id',$libro_id->liga_id)->first();

        return redirect()->route('zona.descarga', $slug->slug);
    }

    public function zonaDescarga(Liga $liga)
    {
        $libro = Libro::where('id', $liga->publicacion[0]->libro_id)->first();

        return view('principal.app', compact('libro'));
    }

    public function registro()
    {
        $estados = Estado::all();
        return view('auth-cliente.register', compact('estados'));
    }

    public function exportClient()
    {
        return Excel::download(new ClientExport, 'Pacientes.xlsx');
    }
}
