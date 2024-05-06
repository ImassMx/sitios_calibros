<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Cart;

class CartController extends Controller
{
    private $countBook = 0;
    private $totalAmount = 0;
    private $totalPoint = 0;

    public function getCart($user){
        try {
            $books = Cart::where('user_id',$user)->with('book')->get();

            foreach ($books as $book) {
                $this->totalAmount += $book->book->price; 
                $this->countBook += 1;
                $this->totalPoint += $book->book->points;
            }

            $data = [
               'countProduct'=> $this->countBook,
               'totalMount'=>number_format($this->totalAmount,2),
               'totalPoint'=> $this->totalPoint
            ];
            
            return response()->json($data);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function catalogCart($user){
        try {
            $books = Cart::where('user_id',$user)->with('book.category')->get();
            return response()->json($books);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function deleteProduct($id){
        try {
            Cart::where('id',$id)->delete();
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
