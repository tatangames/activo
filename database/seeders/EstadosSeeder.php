<?php

namespace Database\Seeders;

use App\Models\Estados;
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
        Estados::create([
            'nombre' => 'EN USO',
            'descripcion' => ''
        ]);

        Estados::create([
            'nombre' => 'DESCARGADO',
            'descripcion' => 'Descargado de inventario'
        ]);

        Estados::create([
            'nombre' => 'VENDIDO',
            'descripcion' => ''
        ]);

        Estados::create([
            'nombre' => 'COMODATO',
            'descripcion' => ''
        ]);

        Estados::create([
            'nombre' => 'DONADO',
            'descripcion' => ''
        ]);
    }
}
