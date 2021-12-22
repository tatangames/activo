<?php

namespace Database\Seeders;

use App\Models\TipoCompra;
use Illuminate\Database\Seeder;

class TipoCompraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoCompra::create([
            'nombre' => 'Nuevo'
        ]);

        TipoCompra::create([
            'nombre' => 'Usado'
        ]);
    }
}
