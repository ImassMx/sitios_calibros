<?php

namespace Database\Seeders;

use App\Models\Especialidad;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EspecialidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Especialidad::create([
            'nombre'=> 'Cirujano',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);

        Especialidad::create([
            'nombre'=> 'Pediatra',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);

        Especialidad::create([
            'nombre'=> 'Neurologo',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
    }
}
