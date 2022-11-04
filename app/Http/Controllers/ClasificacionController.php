<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;
use App\Models\Clasificacion;
use Illuminate\Support\Facades\Log;

class ClasificacionController extends Controller
{

    public function index(Request $request)
    {

        $clasificacion = Clasificacion::where('nombre', 'LIKE', '%' . $request->buscador . '%')->where("nombre", "!=", "Sin Clasificacion")->orderBy("created_at", "desc")->paginate(4);
        return response()->json($clasificacion);
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'nombre' => 'required'
            ],
            [
                'nombre.required' => 'El nombre es requerido'
            ]
        );

        Clasificacion::create([
            'nombre' => $request->nombre
        ]);
    }

    public function edit($id)
    {
        $clasificacion = Clasificacion::where('id', $id)->first();

        return response()->json($clasificacion);
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'nombre' => 'required'
            ],
            [
                'nombre.required' => 'El campo nombre es obligatorio'
            ]
        );

        $clasificacion = Clasificacion::where('id', $id)->first();
        $clasificacion->update([
            'nombre' => $request->nombre
        ]);
        $actualizado = 1;
        return response()->json($actualizado);
    }

    public function destroy($id)
    {
        $Sinclasificacion = Clasificacion::where("nombre", "Sin Clasificacion")->first();

        $libros = Libro::where("clasificacion_id", $id)->get();

        if (count($libros) > 0) {
            foreach ($libros as $book) {
                $book->clasificacion_id = $Sinclasificacion->id;
                $book->save();
            }

            Clasificacion::find($id)->delete();
        } else {
            Clasificacion::find($id)->delete();
        }
    }

    public function clasificacionBook()
    {

        $clasificacion = Clasificacion::where("nombre", "!=", "Sin Clasificacion")->get();
        return response()->json($clasificacion);
    }
}
