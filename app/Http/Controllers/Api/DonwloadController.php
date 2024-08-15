<?php

namespace App\Http\Controllers\Api;

use App\Models\BookSale;
use Illuminate\Http\Request;
use App\Services\DonwloadService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class DonwloadController extends Controller
{

    public  $donwloadService;

    public function __construct(DonwloadService $donwloadService)
    {
        $this->donwloadService = $donwloadService;
    }

    public function donwloadBookDoctor(Request $request,$uuid){
        try {
            $book = BookSale::where('uuid',$uuid)->first();

            if (!$book) {
                return abort(404, 'No de encontró el libro.');
            }
            
            $response = $this->donwloadService->DonwdloadBookDoctorService($request->purchased_book,$book);
            
            return $response;
        } catch (\Throwable $th) {
            Log::error(["Error donwloadBookDoctor" => $th->getMessage()]);
        }
    }
}
