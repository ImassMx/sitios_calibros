<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_sale_id'];

    public function book(){
        return $this->hasOne(BookSale::class,'id','book_sale_id');
    }
}
