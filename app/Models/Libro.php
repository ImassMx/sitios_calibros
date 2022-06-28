<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

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
