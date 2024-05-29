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

    public function purchasedBook()
    {
        return $this->belongsTo(PurchasedBook::class, 'book_sale_id', 'book_sale_id')
                    ->whereColumn('doctor_id', 'doctor_id');
    }

    public function reportBooksMonth(){
        return $this->hasMany(DownloadReportClient::class,'client_id','cliente_id')
                    ->whereColumn('doctor_id', 'doctor_id')
                    ->whereColumn('book_sale_id', 'book_sale_id')
                    ->whereMonth('created_at', now()->month);

    }

    public function reportBooksTotal(){
        return $this->hasMany(DownloadReportClient::class,'client_id','cliente_id')
                    ->whereColumn('doctor_id', 'doctor_id')
                    ->whereColumn('book_sale_id', 'book_sale_id');

    }

}
