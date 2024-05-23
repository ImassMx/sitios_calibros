<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\BookSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class BooksController extends Controller
{
    
    public function BooksMarketplace(Request $request){
        try {

            $filtro = $request->search;
            $booksQuery = BookSale::where('name', 'LIKE', '%' . $filtro . '%')->where('active',1);

            if ($request->categoria) {
                $booksQuery->whereIn('category_id', $request->categoria);
            }
            
            $books = $booksQuery->paginate(8);
            
            return response()->json($books);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function addBooksCart($book,Request $request) {
        try {
            if (empty($request->user)) {
                return response()->json(["message"=> 'redirect'],500);
            }

            $libro = $this->isBook($book);

            Cart::create([
                'user_id'=>json_decode($request->user)->id,
                'book_sale_id'=>$libro->id
            ]);

        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(["message"=> 'redirect'],500);

        }
    }

    private function isBook($uuid){
        try {
            $book = BookSale::where('uuid',$uuid)->first();
            return $book;
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
