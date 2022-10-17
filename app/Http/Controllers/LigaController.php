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

        if ($request->hasFile('logo'))
        $nombre_img = Str::uuid() . "." . $request->logo->getClientOriginalExtension();

        $liga = new Liga();
        $liga->nombre =  $request->nombre;
        $liga->slug  =  Str::slug($request->nombre);
        $liga->celular =  $request->celular;
        $liga->correo  = $request->email;
        $liga->estado = $request->estado;
        $liga->codigo_qr = $nombre_qr;
        $liga->img_lab  = $nombre_img?? '';
        $liga->save();

        if ($request->hasFile('logo'))
        $request->logo->move(public_path('/storage/logo'), $nombre_img);

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

    public function update(Request $request, $id)
    {

        //OBTENER LA RELACION CON PUBLICACION
        $liga_relacion = Liga::where('id', $id)->with('publicacion')->get();
        
        //OBTENER LA LIGA PARA PODER HACER LA ACTUALIZACION
        $liga = Liga::find($id);

        //ACTUALIZAR LA IMAGEN
        if ($request->hasFile('logo')) {
            if($liga->img_lab)
            {
                $port = public_path('/storage/logo') . "\\" . $liga->img_lab;
            if (file_exists($port)) {
                unlink($port);
            }
            }
            $imagen = $request->file('logo');
            $nombreImagen = Str::uuid().".". $imagen->extension();
            $request->logo->move(public_path('/storage/logo'), $nombreImagen);
        }

        $liga->nombre = $request->nombre;
        $liga->slug = Str::slug($request->nombre);
        $liga->celular = $request->celular;
        $liga->estado = $request->estado;
        $liga->img_lab = $nombreImagen ?? $liga->img_lab;
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
        if($cliente)
        {
        $cliente->libro_id = $id;
        $cliente->descargas = $cliente->descargas+1;
        $cliente->fecha_descarga = Carbon::now();
        $cliente->save();
        }else{
        $doctor = Doctor::where('user_id', $request->id_usuario)->first();
        $doctor->descargas = $doctor->descargas + 1;
        $doctor->fecha_descarga = Carbon::now()->format('Y-m-d');
        $doctor->save();   
        }
    }

    public function donwload( Request $request)
    {   
  
          return Storage::disk('local')->download('/public/qr/'.$request->image);
    }
 
}
