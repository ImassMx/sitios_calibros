<?php

namespace App\Exports;

use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ClientExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $clientes = Cliente::with(['user','libro'])->get();
        $date = new Carbon();
        return view('export.Clientes',['clientes' => $clientes,'date' => $date]);
    }
}
