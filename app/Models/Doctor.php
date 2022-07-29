<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable =[
        'especialidad_id',
        'liga_id',
        'nombre',
        'apellidos',
        'folio',
        'descargas',
        'user_id',
        'cp'
    ];

    public function ligas()
    {
      return  $this->hasOne(Liga::class,'id','liga_id');
    }

    public function especialidad()
    {
      return $this->hasOne(Especialidad::class,'id','especialidad_id');
    }
}
