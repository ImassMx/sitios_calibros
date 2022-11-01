<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use Illuminate\Http\Request;

class ClasificacionController extends Controller
{

    public function index(Request $request)
    {

        $clasificacion = Clasificacion::where('nombre','LIKE','%'.$request->buscador.'%')->orderBy("created_at","desc")->paginate(4);
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
        $clasificacion = Clasificacion::where('id',$id)->first();

        return response()->json($clasificacion);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'nombre'=> 'required'
        ],
        [
            'nombre.required'=>'El campo nombre es obligatorio'
        ]
        );

        $clasificacion = Clasificacion::where('id',$id)->first();
        $clasificacion->update([
            'nombre' => $request->nombre
        ]);
        $actualizado =1 ;
        return response()->json($actualizado);
    }

    public function destroy( $id)
    {
        Clasificacion::find($id)->delete();
    }

    public function clasificacionBook(){
        
        $clasificacion = Clasificacion::all();
        return response()->json($clasificacion);
    }
}
