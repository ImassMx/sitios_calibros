<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\CampaniaService;

class CampaniaController extends Controller
{
    public function campaniaSave($compania,Request $request){
        try {
            $ip = $request->ip();
            CampaniaService::saveCompaniaService($compania,$ip);
        } catch (\Throwable $th) {
            Log::error(["Error campaniaSave" => $th->getMessage()]);
        }
    }

    public function clicAcceder($compania,Request $request){
        try {
            $ip = $request->ip();
            CampaniaService::saveClicService($compania,$ip);
        } catch (\Throwable $th) {
            Log::error(["Error campaniaSave" => $th->getMessage()]);
        }
    }
}
