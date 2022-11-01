<?php

namespace App\Http\Controllers;

use App\Models\Liga;
use App\Models\User;
use App\Models\Libro;
use App\Models\Doctor;
use App\Models\Cliente;
use App\Models\Especialidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Facade\FlareClient\Http\Client;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function libros(Request $request)
    {

        $filtro = $request->buscador;
        $libro = Libro::where('nombre', 'LIKE', '%' . $filtro . '%')->orderBy("created_at","desc")->paginate(5);
        return response()->json($libro);
    }

    public function ligas(Request $request)
    {
        $filtro = $request->buscador;
        $ligas = Liga::where("nombre","LIKE","%".$filtro."%")->where("estado","1")->orderBy("created_at","desc")->paginate(4);
        return response()->json($ligas);
    }
    public function especialidad()
    {
        $especialida = Especialidad::orderBy("created_at","desc")->get();

        return response()->json($especialida);
    }

    public function codigoPostal(Request $request)
    {

        if ($request->codigo) {
            $info = DB::table('sepomex')->where('d_codigo', 'LIKE', $request->codigo)->first();
            return response()->json($info);
        }
    }

    public function clientes(Request $request)
    {
        $filtro = $request->buscador;
        $clientes = Cliente::whereHas('user', function ($query) use ($filtro) {
            $query->where('name', 'LIKE', '%' . $filtro . '%')
                ->orWhere('folio', 'LIKE', '%' . $filtro . '%')
                ->orWhere('nombre_doctor', 'LIKE', '%' . $filtro . '%');
        })->with(['user', 'libro'])->orderBy("created_at","desc")->paginate(4);

       
        return response()->json($clientes);
    }

    public function doctores(Request $request)
    {
        $filtro = $request->buscador;   

        $doctores = Doctor::whereHas('especialidad', function ($query) use ($filtro) {
                $query->where('nombre', 'LIKE', '%' . $filtro . '%')
                    ->orWhere('folio', 'LIKE', '%' . $filtro . '%')
                    ->orWhere('apellidos', 'LIKE', '%' . $filtro . '%')
                    ->orWhere('nombres', 'LIKE', '%' . $filtro . '%')
                    ;
            })->with(['ligas', 'especialidad'])->orderBy("created_at","desc")->paginate(4);


        return response()->json($doctores);
    }

    public function folio(Request $request)
    {
        if ($request->folio) {
            $doctor = Doctor::where('folio', 'LIKE', $request->folio)->first();

            if ($doctor) {
                $nombre_doctor = $doctor->nombres . " " . $doctor->apellidos;

                return response()->json($nombre_doctor);
            }
        }
    }

    public function ValidarEmail(Request $request)
    {
       
        if($request->correo){
            $email = User::where('email','LIKE',$request->correo)->get();
        dump($email);
        return response()->json($email);
        }
    }
    public function getDatosSlug(Request $request)
    {
        $liga = Liga::where('id',$request->id)->first();
        $publicacion = DB::table('publicacions')->where('liga_id',$request->id)->first();
        $libro = Libro::find($publicacion->libro_id);

        return response()->json([$liga,$libro]);
    }

    public function getLogo(Request $request)
    {
        $logo = Liga::find($request->id);
        $url = Storage::url($logo->img_lab);

        return response()->json($url);
    }

    public function getDatosDoctor($folio)
    {
        $doctor = Doctor::where('folio',$folio)->first();

        if($doctor)
        {
          $user = User::find($doctor->user_id);
 
          return response()->json($user);
        }else{
 
         return response()->json(500,2);
        }
    }

    public function getNombreDoctor($folio)
    {
        $doctor = Doctor::where('folio',$folio)->first();
          return response()->json($doctor);
    
    }

    public function validacionDescarga($id)
    {   
       $cliente = Cliente::where("user_id",$id)->first();

       return response()->json($cliente->descargas);
    }
}
