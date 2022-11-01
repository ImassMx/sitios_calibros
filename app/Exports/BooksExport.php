<?php

namespace App\Exports;

use App\Models\Libro;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BooksExport implements FromView 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $libros = Libro::all();

        return view('export.Libros',['libros' => $libros]);
    }
}
