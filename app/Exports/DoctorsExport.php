<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Doctor;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DoctorsExport implements FromView,ShouldAutoSize
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
    public function view():View
    {
        $startDate = $this->startDate;
        $endDate = $this->endDate;

        $doctor = Doctor::with('ligas')->with(['especialidad','user','sepomex'])
        ->when($startDate, function ($query, $startDate) {
            return $query->where('created_at', '>=', $startDate);
        })
        ->when($endDate, function ($query, $endDate) {
            return $query->where('created_at', '<=', $endDate);
        })->get();
        $date = new Carbon();

        return view('export.Doctores',['doctores' => $doctor,'date'=> $date]);
    }
}
