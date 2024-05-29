<?php

namespace App\Exports;

use App\Models\ClientBook;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class BookPaciente implements  FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $books = ClientBook::with(['book', 'client.user', 'doctor', 'client.sepomex'])->get();
        return view('export.pacienteBooks',compact('books'));
    }
}
