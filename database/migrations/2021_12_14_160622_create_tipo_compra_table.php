<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoCompraTable extends Migration
{
    /**
     * nuevo
     * usado
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_compra', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_compra');
    }
}
