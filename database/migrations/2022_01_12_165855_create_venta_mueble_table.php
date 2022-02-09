<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentaMuebleTable extends Migration
{
    /**
     * lista de venta mueble
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venta_mueble', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_bienmueble')->unsigned();

            $table->string('observaciones', 450)->nullable();
            $table->decimal('precio', 10,2)->nullable();
            $table->string('documento', 100)->nullable();
            $table->date('fecha')->nullable();

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
        Schema::dropIfExists('venta_mueble');
    }
}
