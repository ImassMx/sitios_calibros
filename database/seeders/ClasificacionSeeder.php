<?php

namespace Database\Seeders;

use App\Models\Clasificacion;
use Illuminate\Database\Seeder;

class ClasificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Clasificacion::updateOrCreate([
            'nombre'=> "Sin Clasificacion"
        ]);
    }
}
