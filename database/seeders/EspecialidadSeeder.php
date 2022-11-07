<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Especialidad;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspecialidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Especialidad::updateOrCreate([
            'nombre'=> 'Médicos Generales',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);

        Especialidad::updateOrCreate([
            'nombre'=> 'Dermatólogos ',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);

        Especialidad::updateOrCreate([
            'nombre'=> 'Cardiólogos',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::updateOrCreate([
            'nombre'=> 'Internistas',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::updateOrCreate([
            'nombre'=> 'Endocrinólogos',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::updateOrCreate([
            'nombre'=> 'Psiquiatras',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::updateOrCreate([
            'nombre'=> 'Psicólogos',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::updateOrCreate([
            'nombre'=> 'Urólogos',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::updateOrCreate([
            'nombre'=> 'Ginecólogos',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::updateOrCreate([
            'nombre'=> 'Odontólogos',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::updateOrCreate([
            'nombre'=> 'Pediatras',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::updateOrCreate([
            'nombre'=> 'Gastroenterólogos',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::updateOrCreate([
            'nombre'=> 'Oncólogos',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::updateOrCreate([
            'nombre'=> 'Hematólogos',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);

    }
}
