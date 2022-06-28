<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Jherson Kayro',
            'email'=> 'jhersontrigoso14@gmail.com',
            'password' => bcrypt('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ])->assignRole('Admin');

        User::create([
            'name' => 'Kayro',
            'email'=> 'jherson@gmail.com',
            'password' => bcrypt('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ])->assignRole('Asistente');
    }
}
