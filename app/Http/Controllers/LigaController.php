<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Liga;
use App\Models\Libro;
use App\Models\Doctor;
use App\Models\Cliente;
use App\Models\Publicacion;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LigaController extends Controller
{

    public function __construct()
    {
        /* $this->middleware('auth'); */
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'nombre' => 'required',
                'celular' => 'required',
                'email' => 'required',
                'book' => 'required'
            ],
            [
                'nombre.required' => 'EL nombre es requerido',
                'celular.required' => 'EL celular es requerido',
                'email.required' => 'EL email es requerido',
                'book.required' => 'Debe asignar un libro a la liga',
            ]
        );
        $nombre_qr = Str::uuid() . '.png';

        $liga = new Liga();
        $liga->nombre =  $request->nombre;
        $liga->slug  =  Str::slug($request->nombre);
        $liga->celular =  $request->celular;
        $liga->correo  = $request->email;
        $liga->estado = $request->estado;
        $liga->codigo_qr = $nombre_qr;
         $liga->save();

        Publicacion::create([
            'liga_id' => $liga->id,
            'libro_id' => $request->book
        ]);

        $dominio = $_SERVER['HTTP_HOST'];
        $slug = $dominio . '/registrar/doctor?slug_id=' . $liga->id;

        $codigo = QrCode::size(300)->format('png')->generate($slug);

        Storage::disk('local')->put('/public/qr/' . $nombre_qr, $codigo);

        return response()->json(['respuesta' => 'Creado']);
    }


    public function edit($id)
    {
        $liga = Liga::where('id', $id)->with('publicacion')->get();
        return response()->json($liga);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Liga  $liga
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* dump($id); */
        //OBTENER LA RELACION CON PUBLICACION
        $liga_relacion = Liga::where('id', $id)->with('publicacion')->get();
        //OBTENER LA LIGA PARA PODER HACER LA ACTUALIZACION
        $liga = Liga::find($id);
        $liga->nombre = $request->nombre;
        $liga->slug = Str::slug($request->nombre);
        $liga->celular = $request->celular;
        $liga->estado = $request->estado;
        $liga->save();

        $id_publicacion =  $liga_relacion[0]->publicacion[0]->id;

        $publicacion = Publicacion::where('id', $id_publicacion)->first();
        $actualizacion = $publicacion->update([
            'libro_id' => $request->book
        ]);

        if ($actualizacion) {
            $actualizado = 1;
        }

        return response()->json($actualizado);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Liga  $liga
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $liga = Liga::find($id);

        $liga->estado = 0;
        $liga->save();

        $eliminado = 1;

        return response()->json($eliminado);
    }
    public function viewDescarga(Request $request, $id)
    {
        $libro = Libro::find($id);

        $libro->update([
            'descargas' => $request->descarga
        ]);

        $cliente = Cliente::where('user_id', $request->id_usuario)->first();
        $cliente->libro_id = $id;
        $cliente->fecha_descarga = Carbon::now();
        $cliente->save();

        $doctor = Doctor::where('folio', $cliente->folio)->first();
        $doctor->descargas = $doctor->descargas + 1;
        $doctor->save();
    }

 
}
