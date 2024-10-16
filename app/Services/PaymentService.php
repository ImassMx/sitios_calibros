<?php

namespace App\Services;

use App\Models\Doctor;
use Illuminate\Support\Facades\Log;


class PaymentService {

    public static function updatedPointsDoctorService($doctor,$points){
        try {

            $doctor->points += $points;
            $doctor->save();

        } catch (\Throwable $th) {
            Log::error(["Error updatedPointsDoctorService" => $th->getMessage()]);
        }
    }

}
