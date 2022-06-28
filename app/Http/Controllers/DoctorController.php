<?php

namespace App\Http\Controllers;

use App\Exports\DoctorsExport;
use App\Models\Liga;
use App\Models\Doctor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
            $folio = mt_rand(10000,99999);
            Doctor::create([
                'especialidad_id'=> $request->especialidad,
                'liga_id'=> $request->id_slug,
                'nombre' => $request->nombre,
                'apellidos' => $request->apellidos,
                'folio' => $folio
            ]);
            return response()->json($folio);
        }else{
            return response()->json(1,500);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
    public function exportDoctor()
    {
        return Excel::download(new DoctorsExport, 'Doctores.xlsx'); 
    }
}
