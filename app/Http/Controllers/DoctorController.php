<?php

namespace App\Http\Controllers;

use App\Models\Liga;
use App\Models\Doctor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\DoctorsExport;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

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
}
