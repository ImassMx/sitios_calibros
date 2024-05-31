<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\PurchasedBook;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportVentas implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $books = PurchasedBook::with(['book','doctor'])->get();

        return view('export.Ventas',['books' => $books]);
    }
}
