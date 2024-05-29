<?php

namespace App\Exports;

use App\Models\PurchasedBook;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BookDoctor implements FromView,ShouldAutoSize
{
   
    public function view(): View
    {
        $books = PurchasedBook::with(['user.doctorReport.especialidad', 'book', 'user.doctorReport.sepomex']);


        $books = $books->get();

        return view('export.doctorBooks',compact('books'));
    }
}
