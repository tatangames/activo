<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // --- CREAR ROLES ---

        // encargado administrador
        $role1 = Role::create(['name' => 'Encargado-Administrador']);


        // --- CREAR PERMISOS ---

        // visualizar roles y permisos
        Permission::create(['name' => 'vista.principal', 'description' => 'vista de roles y permisos'])->syncRoles($role1);

    }
}
