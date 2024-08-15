<?php

namespace App\Services;

use App\Models\PurchasedBook;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class DonwloadService {

    public function DonwdloadBookDoctorService($purchased_book,$book){
        try {
            
            $purchased = PurchasedBook::where('id',$purchased_book)->first();

            $book->downloads +=1;
            $book->save();

            $purchased->donwloads += 1;
            $purchased->save();

            $parsedUrl = parse_url($book->pdf);

            return Storage::disk('s3')->download($parsedUrl['path'],$book->name.'.pdf');
        } catch (\Throwable $th) {
            Log::error(["Error DonwdloadBookDoctorService" => $th->getMessage()]);
        }
    }

}
