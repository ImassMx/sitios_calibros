<?php

namespace App\Exports;

use App\Models\Doctor;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DoctorsExport implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $doctor = Doctor::with('ligas')->with('especialidad')->get();

        return view('export.Doctores',['doctores' => $doctor]);
    }
}
