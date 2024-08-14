<?php

namespace App\Http\Controllers\Api;

use App\Models\Doctor;
use App\Models\BookSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\PurchasedBook;
use Illuminate\Support\Facades\Storage;

class DonwloadController extends Controller
{
    public function donwloadBookDoctor(Request $request,$uuid){
        try {
            $book = BookSale::where('uuid',$uuid)->first();

            if (!$book) {
                return abort(404, 'No de encontró el libro.');
            }

            $purchased = PurchasedBook::where('id',$request->purchased_book)->first();

            if(!empty($book)){

                $book->downloads +=1;
                $book->save();

                $purchased->donwloads += 1;
                $purchased->save();
                $parsedUrl = parse_url($book->pdf);
                return Storage::disk('s3')->download($parsedUrl['path'],$book->name.'.pdf');
            }
        } catch (\Throwable $th) {
            Log::error(["Error donwloadBookDoctor" => $th->getMessage()]);
        }
    }
}
