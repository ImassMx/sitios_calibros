<?php

namespace App\Exports;

use App\Models\PurchasedBook;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BookDoctor implements FromView,ShouldAutoSize
{
   
    public function view(): View
    {
        $books = PurchasedBook::with(['book','user'])->get();
        return view('export.doctorBooks',compact('books'));
    }
}
