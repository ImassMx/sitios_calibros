<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol1 = Role::updateOrCreate(['name' => 'Admin']);
        $rol2 = Role::updateOrCreate(['name' => 'Asistente']);
        $rol3 = Role::updateOrCreate(['name' => 'Cliente']);
        $rol4 = Role::updateOrCreate(['name' => 'Ejecutivo']);

        Permission::updateOrCreate(['name' => 'usuarios'])->syncRoles([$rol1]);
        Permission::updateOrCreate(['name' => 'libros'])->syncRoles([$rol1,$rol4]);
        Permission::updateOrCreate(['name' => 'ligas'])->syncRoles([$rol1,$rol4]);
        Permission::updateOrCreate(['name' => 'reportes'])->syncRoles([$rol1,$rol2,$rol4]);
        
    }
}
