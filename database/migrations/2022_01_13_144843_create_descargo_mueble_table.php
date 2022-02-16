<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescargoMuebleTable extends Migration
{
    /**
     * lista de descargos muebles
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descargo_mueble', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_bienmueble')->unsigned();

            $table->decimal('valor', 10,2)->nullable();
            $table->string('observaciones', 450)->nullable();
            $table->date('fecha')->nullable(); // fecha descargo

            $table->foreign('id_bienmueble')->references('id')->on('bienes_muebles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('descargo_mueble');
    }
}
