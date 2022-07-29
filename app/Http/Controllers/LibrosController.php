<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Support\Str;
use App\Exports\BooksExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class LibrosController extends Controller
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
        $libro = Libro::all();
        return response()->json($libro);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'nombre' => 'required',
                'portada' => 'required|mimes:png,jpg,jpeg',
                'descripcion' => 'required',
                'clasificacion' => 'required',
                'pdf' => 'required|mimes:pdf',
            ],
            [
                'nombre.required' => 'El nombre del libro es requerido',
                'descripcion.required' => 'La descripción es requerida',
                'clasificacion.required' => 'La clasificación es necesaria',
                'portada.required' => 'Ingrese una portada del libro por favor',
                'portada.mimes' => 'Ingrese una imagen válida',
                'pdf.required' => 'Es necesario ingresar el pdf del libro',
                'pdf.mimes' => 'Ingrese un archivo pdf válido '
            ]
        );

        //INSERTAR IMAGEN
        $nombre_img = Str::uuid() . "." . $request->portada->getClientOriginalExtension();
        $request->portada->move(public_path('/admin/portada'), $nombre_img);

        //INSERTAR PDF
        $nombre_pdf = Str::uuid() . "." . $request->pdf->guessExtension();
        $request->pdf->move(public_path('libros'), $nombre_pdf);

        $libro = new Libro();
        $libro->nombre = $request->nombre;
        $libro->portada = $nombre_img;
        $libro->descripcion = $request->descripcion;
        $libro->clasificacion_id = $request->clasificacion;
        $libro->pdf = $nombre_pdf;
        $libro->estado = $request->estado;
        $libro->save();
        return response()->json(['resultado' => $request]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $libros = Libro::where('id', $id)->first();

        return response()->json($libros);
    }


    public function update(Request $request, $id)
    {
        $libro = Libro::find($id);
        if ($request->hasFile('portada')) {
            $port = public_path('\admin\portada') . "\\" . $libro->portada;
            if (file_exists($port)) {
                unlink($port);
            }
            $nombre_img = Str::uuid() . "." . $request->portada->getClientOriginalExtension();
            $request->portada->move(public_path('/admin/portada'), $nombre_img);
        }
        if ($request->hasFile('pdf')) {
            $libropdf = public_path('libros') . "/" . $libro->pdf;
            if (file_exists($libropdf)) {
                unlink($libropdf);
            }

            $nombre_pdf = Str::uuid() . "." . $request->pdf->guessExtension();
            $request->pdf->move(public_path('libros'), $nombre_pdf);
        }

        

        $libro->update([
            'nombre' => $request->nombre,
            'portada' => $nombre_img ?? $libro->portada,
            'descripcion' => $request->descripcion,
            'pdf' => $nombre_pdf ?? $libro->pdf,
            'clasificacion_id' => $request->clasificacion,
            'estado' => $request->estado
        ]);

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $libro = Libro::find($id);
        $libro->delete();
        $libropdf = public_path('libros') . "/" . $libro->pdf;
        $port = public_path('admin/portada') . "/" . $libro->portada;
        unlink($port);
        unlink($libropdf);
    }

    public function desactivar($id)
    {
        $libro = Libro::find($id);

        $libro->update([
            'estado' => 2
        ]);
    }

    public function activar($id)
    {
        $libro = Libro::find($id);

        $libro->update([
            'estado' => 1
        ]);
    }

    public function exportBook()
    {
        return Excel::download(new BooksExport, 'Libros.xlsx');
    }
}
