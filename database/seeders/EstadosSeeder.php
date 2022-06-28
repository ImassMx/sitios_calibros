<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Seeder;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estado::create([
            'nombre'=> 'Aguascalientes'
        ]);
        
        Estado::create([
            'nombre'=> 'Baja California'
        ]);
        
        Estado::create([
            'nombre'=> 'Campeche'
        ]);

        Estado::create([
            'nombre'=> 'Chiapas'
        ]);

        Estado::create([
            'nombre'=> 'Chihuahua'
        ]);

        Estado::create([
            'nombre'=> 'Coahuila'
        ]);

        Estado::create([
            'nombre'=> 'Colima'
        ]);

        Estado::create([
            'nombre'=> 'Ciudad de México'
        ]);

        Estado::create([
            'nombre'=> 'Durango'
        ]);

        Estado::create([
            'nombre'=> 'Estado de México'
        ]);

        Estado::create([
            'nombre'=> 'Guanajuato'
        ]);

        Estado::create([
            'nombre'=> 'Guerrero'
        ]);

        Estado::create([
            'nombre'=> 'Hidalgo'
        ]);

        Estado::create([
            'nombre'=> 'Jalisco'
        ]);

        Estado::create([
            'nombre'=> 'Michoacán'
        ]);

        Estado::create([
            'nombre'=> 'Morelos'
        ]);

        Estado::create([
            'nombre'=> 'Nayarit'
        ]);

        Estado::create([
            'nombre'=> 'Nuevo León'
        ]);

        Estado::create([
            'nombre'=> 'Oaxaca'
        ]);

        Estado::create([
            'nombre'=> 'Puebla'
        ]);

        Estado::create([
            'nombre'=> 'Querétaro'
        ]);

        Estado::create([
            'nombre'=> 'Quintana Roo'
        ]);

        Estado::create([
            'nombre'=> 'San Luis Potosí'
        ]);

        Estado::create([
            'nombre'=> 'Sinaloa'
        ]);

        Estado::create([
            'nombre'=> 'Sonora'
        ]);

        Estado::create([
            'nombre'=> 'Tabasco'
        ]);

        Estado::create([
            'nombre'=> 'Tamaulipas'
        ]);

        Estado::create([
            'nombre'=> 'Tlaxcala'
        ]);

        Estado::create([
            'nombre'=> 'Veracruz'
        ]);

        Estado::create([
            'nombre'=> 'Yucatán'
        ]);

        Estado::create([
            'nombre'=> 'Zacatecas'
        ]);
    }
}
