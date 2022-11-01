<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Libro extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
            'nombre',
            'portada',
            'descripcion',
            'pdf',
            'clasificacion_id',
            'descargas',
            'estado'
    ];

    public function publicacion()
    {
        return $this->hasMany(Publicacion::class);
    }

    public function clasificacion()
    {
        return $this->hasOne(Clasificacion::class);
    }
}
