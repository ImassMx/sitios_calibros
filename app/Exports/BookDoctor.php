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
    protected $startDate;
    protected $endDate;

    public function __construct($startDate,$endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
   
    public function view(): View
    {
        $startDate = $this->startDate;
        $endDate = $this->endDate;

        $books = PurchasedBook::with(['user.doctorReport.especialidad', 'book', 'user.doctorReport.sepomex'])
        ->when($startDate, function ($query, $startDate) {
            return $query->where('created_at', '>=', $startDate);
        })
        ->when($endDate, function ($query, $endDate) {
            return $query->where('created_at', '<=', $endDate);
        });

        $books = $books->get();

        return view('export.doctorBooks',compact('books'));
    }
}
