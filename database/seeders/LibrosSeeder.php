<?php

namespace Database\Seeders;

use App\Models\Libro;
use Illuminate\Database\Seeder;

class LibrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Libro::create([
            'nombre' => 'El cancer',
            'portada' => '1a6b44e6-d6b0-4dff-896f-d94c89d8690d.jpeg',
            'descripcion' => 'Es una enfermedad que tiene cura',
            /* 'clasificacion' => 'Diabetes', */
            'estado'=> 1
        ]);
        Libro::create([
            'nombre' => 'La Diabetes',
            'portada' => '1a6b44e6-d6b0-4dff-896f-d94c89d8690d.jpeg',
            'descripcion' => 'Es una enfermedad que tiene cura',
            /* 'clasificacion' => 'Diabetes', */
            'estado'=> 1
        ]);
        Libro::create([
            'nombre' => 'El VIH',
            'portada' => '31c58e30-d884-4f0f-bfe0-6d1220521c72.jpeg',
            'descripcion' => 'Es una enfermedad que tiene cura',
            /* 'clasificacion' => 'Diabetes', */
            'estado'=> 1
        ]);
        Libro::create([
            'nombre' => 'La gonorrea',
            'portada' => '3c15bd74-ef58-4b5c-aedd-6ca93d1c788a.PNG',
            'descripcion' => 'Es una enfermedad que tiene cura',
            /* 'clasificacion' => 'Diabetes', */
            'estado'=> 1
        ]);
    }
}
