<?php

namespace App\Http\Controllers;

use App\Models\BookSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MarketplaceController extends Controller
{
   
    public function index(){   
    return view('marketplace.index');
    }

    public function detalleLibro($uuid){
        $book = BookSale::where('uuid',$uuid)->with('category')->first();
        return view('marketplace.detalleLibro',compact('book'));
    }

     public function carrito(){
        return view('marketplace.carrito');
    }

    public function pago(){
        return view('marketplace.pago');
    }

    public function compra(){
        return view('marketplace.compra');
    }

    public function pasarela(){
        return view('marketplace.pasarela');
    }

    public function successPayment(){
        return view('marketplace.avisos.success');
    }
}