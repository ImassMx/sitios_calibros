<?php

namespace App\Exports;

use App\Models\ClientBook;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class BookPaciente implements  FromView,ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate,$endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $startDate = $this->startDate;
        $endDate = $this->endDate;

        $books = ClientBook::with(['book', 'client.user', 'doctor', 'client.sepomex'])
        ->when($startDate, function ($query, $startDate) {
            return $query->where('created_at', '>=', $startDate);
        })
        ->when($endDate, function ($query, $endDate) {
            return $query->where('created_at', '<=', $endDate);
        })->get();
        
        return view('export.pacienteBooks',compact('books'));
    }
}
