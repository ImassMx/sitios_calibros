<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Liga extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
            'nombre',
            'slug',
            'celular',
            'correo',
            'estado',
            'fecha_inicio',
            'fecha_final',
            'codigo_qr',
            'status'
    ];

    public function publicacion()
    {
        return $this->hasMany(Publicacion::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
