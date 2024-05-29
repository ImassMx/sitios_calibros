<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cliente extends Authenticatable
{
    use HasFactory;

    protected $guard = 'client';

    protected $fillable = [
        'user_id',
        'nombre_doctor',
        'folio',
        'celular',
        'codigo_postal',
        'alcaldia',
        'descargas',
        'nombre_paciente',
        'ciudad',
        'estado',
        'libro_id',
        'fecha_descarga',
        'uuid'
    ];

    public function estado()
    {
        return $this->hasOne(Estado::class);
    }

    public function libro()
    {
        return $this->hasMany(Libro::class, 'id', 'libro_id')->withTrashed();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function sepomex(){
        return $this->hasOne(Sepomex::class,'d_codigo','codigo_postal');
    }
}
