<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use Illuminate\Http\Request;

class ClasificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $clasificacion = Clasificacion::where('nombre','LIKE','%'.$request->buscador.'%')->paginate(4);
        return response()->json($clasificacion);
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

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clasificacion  $clasificacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clasificacion = Clasificacion::where('id',$id)->first();

        return response()->json($clasificacion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clasificacion  $clasificacion
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clasificacion  $clasificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        Clasificacion::find($id)->delete();
    }

    public function clasificacionBook(){
        
        $clasificacion = Clasificacion::all();
        return response()->json($clasificacion);
    }
}
