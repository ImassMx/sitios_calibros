<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasedBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_sale_id'
    ];


    public function book(){
        return $this->hasOne(BookSale::class,'id','book_sale_id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
