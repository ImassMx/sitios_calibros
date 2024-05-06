<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookSale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "uuid",
        "name",
        "image",
        "category_id",
        "author",
        "description",
        "price",
        "points",
        "downloads",
        "pdf",
        'password',
        "active",
    ];

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
}
