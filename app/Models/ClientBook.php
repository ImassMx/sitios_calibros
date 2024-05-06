<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientBook extends Model
{
    use HasFactory;

    protected $fillable =[
        'cliente_id',
        'book_sale_id',
        'doctor_id'
    ];

    public function book(){
        return $this->hasOne(BookSale::class,'id','book_sale_id');
    }

    public function client(){
        return $this->hasOne(Cliente::class,'id','cliente_id');
    }

    public function doctor(){
        return $this->hasOne(Doctor::class,'id','doctor_id');
    }
}
