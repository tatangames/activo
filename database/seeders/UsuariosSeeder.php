<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuario::create([
            'nombre' => 'Jonathan',
            'apellido' => 'Moran',
            'usuario' => 'jonathan',
            'password' => bcrypt('admin'),
            'activo' => 1,
        ])->assignRole('Encargado-Administrador');

        Usuario::create([
            'nombre' => 'Giovany',
            'apellido' => 'Rosales',
            'usuario' => 'giova',
            'password' => bcrypt('admin'),
            'activo' => 1,
        ])->assignRole('Encargado-Administrador');

        Usuario::create([
            'nombre' => 'Esmeralda',
            'apellido' => 'Rodriguez',
            'usuario' => 'esme',
            'password' => bcrypt('admin'),
            'activo' => 1,
        ])->assignRole('Encargado-Sistema');

    }
}
