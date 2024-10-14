<?php

namespace App\Services;

use App\Models\Campania;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CampaniaService {

    public static function saveCompaniaService($campania ,$ip){
        try {

            $campa = new Campania();
            $campa->date = Carbon::now()->format('Y-m-d');
            $campa->time = Carbon::now()->format('H:i:s');
            $campa->load = true;
            $campa->ip = $ip;
            $campa->campania = $campania;
            $campa->save();

        } catch (\Throwable $th) {
            Log::error(["Error saveCompaniaService" => $th->getMessage()]);
        }
    }

    public static function saveClicService($campania ,$ip){
        try {

            $campa = Campania::where(['ip' => $ip,'campania' => $campania])->latest()
            ->first();
        
            if(!empty($campa)){
                $campa->clic = true;
                $campa->save();
            }

        } catch (\Throwable $th) {
            Log::error(["Error saveCompaniaService" => $th->getMessage()]);
        }
    }
}
