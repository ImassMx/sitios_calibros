<?php

namespace App\Http\Controllers;

use App\Models\Liga;
use App\Models\User;
use App\Models\Libro;
use App\Models\Doctor;
use App\Models\Cliente;
use App\Mail\ContactForm;
use App\Models\BookSale;
use App\Models\Especialidad;
use App\Models\PurchasedBook;
use App\Models\Sepomex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function libros(Request $request) {
        $filtro = $request->buscador;
        $libro = Libro::where('nombre', 'LIKE', '%' . $filtro . '%')
                ->where('active',1)->orderBy("created_at","desc")->paginate(5);
        return response()->json($libro);
    }

    public function ligas(Request $request) {
        $filtro = $request->buscador;
        $ligas = Liga::where("nombre","LIKE","%".$filtro."%")->where("estado","1")->orderBy("created_at","desc")->paginate(4);
        return response()->json($ligas);
    }

    public function especialidad() {
        $especialida = Especialidad::orderBy("created_at","desc")->get();
        return response()->json($especialida);
    }

    public function codigoPostal(Request $request) {
        if ($request->codigo) {
            $info = DB::table('sepomex')->where('d_codigo', 'LIKE', $request->codigo)->first();
            return response()->json($info);
        }
    }

    public function clientes(Request $request)
    {
        try {
            $filtro = $request->buscador;
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            $clientes = Cliente::whereHas('user', function ($query) use ($filtro) {
                $query->where('name', 'LIKE', '%' . $filtro . '%')
                    ->orWhere('folio', 'LIKE', '%' . $filtro . '%');
            })->with(['user', 'libro','sepomex'])
            ->when($startDate, function ($query, $startDate) {
                return $query->where('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->where('created_at', '<=', $endDate);
            })
            ->orderBy("created_at","desc")->paginate(9);

            return response()->json($clientes);
        } catch (\Throwable $th) {
            Log::error(["Error clientes" => $th->getMessage()]);
        }
    }

    public function doctores(Request $request)
    {
        try {
            $filtro = $request->buscador;   
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
    
            $doctores = Doctor::whereHas('especialidad', function ($query) use ($filtro) {
                    $query->where('nombre', 'LIKE', '%' . $filtro . '%')
                        ->orWhere('folio', 'LIKE', '%' . $filtro . '%')
                        ->orWhere('apellidos', 'LIKE', '%' . $filtro . '%')
                        ->orWhere('nombres', 'LIKE', '%' . $filtro . '%');
                })->with(['especialidad','user','sepomex'])
                ->when($startDate, function ($query, $startDate) {
                    return $query->where('created_at', '>=', $startDate);
                })
                ->when($endDate, function ($query, $endDate) {
                    return $query->where('created_at', '<=', $endDate);
                })
                ->orderBy("created_at","desc")->paginate(10);
    
                return response()->json($doctores);
        } catch (\Throwable $th) {
            Log::error(["Error doctores" => $th->getMessage()]);
        }
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

    public function ValidarEmail(Request $request) {
        if ($request->correo) {
            $email = User::where('email', 'LIKE', $request->correo)->get();
            return response()->json($email);
        }
    }

    public function validateCedula(Request $request){
        try {
            $doctor = Doctor::where('cedula',$request->cedula)->first();
            return response()->json(!empty($doctor) ? true : false);
        } catch (\Throwable $th) {
            Log::error(["Error validateCedula" => $th->getMessage()]);
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
        $doctor = Doctor::where('folio', $folio)->first();

        if ($doctor) {
            $user = User::find($doctor->user_id);
            return response()->json($user);
        } else {
            return response()->json(500, 2);
        }
    }

    public function getNombreDoctor($folio)
    {
        $doctor = Doctor::where('folio', $folio)->first();
        return response()->json($doctor);
    }

    public function validacionDescarga($id)
    {
        $cliente = Cliente::where("user_id", $id)->first();
        return response()->json($cliente->descargas);
    }

    public function sendEmail(Request $request){
        Mail::to(env('EMAIL_CONTACT'))->send(new ContactForm($request->all()));
        return back()->with('mensaje','Se envió correctamente');
     }

     public function validateEmail(Request $request){
        try {
            $user = User::where('email',$request->email)->first();
            return !empty($user) ? $user : null;
        } catch (\Throwable $th) {
            Log::error(["Error validateEmail" => $th->getMessage()]);
        }
     }

     public function validatePhone(Request $request){
        try {
            $user = User::where('celular',$request->celular)->first();
            return !empty($user) ? $user : null;
        } catch (\Throwable $th) {
            Log::error(["Error validatePhone" => $th->getMessage()]);
        }
     }

     public function validateBook($book){
        try {
            $bo = BookSale::where('uuid',$book)->first();
            return response()->json([
                'data' => !empty($bo) ? $bo : null
            ]);

        } catch (\Throwable $th) {
            Log::error(["Error validateBook" => $th->getMessage()]);
        }
     }

     public function deleteBookSale(Request $request){
        try {
            $bookSale = BookSale::where('id',$request->book)->first();
            $bookSale->active = 0;
            $bookSale->save();
        } catch (\Throwable $th) {
            Log::error(["Error deleteBookSale" => $th->getMessage()]);
        }
     }

     public function getUuidDoctor($id){
        try {
            $doctor = Doctor::where('user_id',$id)->first();
            return response()->json($doctor->uuid);
        } catch (\Throwable $th) {
            Log::error(["Error getUuidDoctor" => $th]);
        }
     }

     public function validatePostal(Request $request){
        try {
            $sepomex = Sepomex::where('d_codigo',$request->postal)->first();
            return response()->json(!empty($sepomex) ? true : false);
        } catch (\Throwable $th) {
            Log::error(["Error validatePostal" => $th->getMessage()]);
        }
     }

     public function validateBuyBook(Request $request){
        try {
            $user = json_decode($request->user);
            $doctor = Doctor::where('user_id',$user->id)->first();
            $book = BookSale::where('uuid',$request->book)->first();

            if(!empty($doctor) && !empty($book)){

                $purchased_book = PurchasedBook::where(
                    [
                        'user_id' => $user->id,
                        'book_sale_id' => $book->id,
                        'doctor_id' => $doctor->id
                    ]
                )->first();

                if(!empty($purchased_book)){
                    return response()->json(true);
                }

                return response()->json(false);
            }

            return response()->json(false);

        } catch (\Throwable $th) {
            Log::error([
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'function' => 'validateBuyBook'
            ]);
        }
     }
}
