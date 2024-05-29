<?php

namespace App\Models;

use App\Models\Liga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Especialidad;
use Hrshadhin\Userstamps\UserstampsTrait;

class Doctor extends Model
{
  use HasFactory;


  protected $softDelete = true;

  protected $fillable = [
    'especialidad_id',
    'nombres',
    'apellidos',
    'folio',
    'descargas',
    'user_id',
    'cedula',
    'cp',
    'uuid'
  ];

  public function ligas()
  {
    return  $this->hasOne(Liga::class, 'id', 'liga_id')->withTrashed();
  }

  public function especialidad()
  {
    return $this->hasOne(Especialidad::class, 'id', 'especialidad_id');
  }

  public function user(){
    return $this->hasOne(User::class,'id','user_id');
  }

  public function sepomex(){
    return $this->belongsTo(Sepomex::class,'cp','d_codigo');
  }

  public function purchasedBooks()
  {
      return $this->hasMany(PurchasedBook::class, 'user_id', 'user_id');
  }

  public function clientBooks()
  {
      return $this->hasMany(ClientBook::class, 'doctor_id', 'id');
  }
}
