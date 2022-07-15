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
        Especialidad::create([
            'nombre'=> 'Cardiología',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::create([
            'nombre'=> 'Psiquiatría',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::create([
            'nombre'=> 'Neurocirugía',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::create([
            'nombre'=> 'Oftalmología',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::create([
            'nombre'=> 'Anestesiología',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::create([
            'nombre'=> 'Cirugía Pediátrica',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::create([
            'nombre'=> 'Cirugía General',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::create([
            'nombre'=> 'Dermatología',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::create([
            'nombre'=> 'Medicina Interna',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::create([
            'nombre'=> 'Neumología',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::create([
            'nombre'=> 'Ortopedia',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
        Especialidad::create([
            'nombre'=> 'Otorrinolaringología',
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
    }
}
