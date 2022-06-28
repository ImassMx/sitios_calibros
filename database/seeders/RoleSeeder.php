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
        $rol1 = Role::create(['name' => 'Admin']);
        $rol2 = Role::create(['name' => 'Asistente']);
        $rol3 = Role::create(['name' => 'Cliente']);

        Permission::create(['name' => 'usuarios'])->syncRoles([$rol1]);
        Permission::create(['name' => 'libros'])->syncRoles([$rol1]);
        Permission::create(['name' => 'ligas'])->syncRoles([$rol1]);
        Permission::create(['name' => 'reportes'])->syncRoles([$rol1,$rol2]);
        
    }
}
