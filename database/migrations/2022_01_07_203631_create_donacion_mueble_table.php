<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonacionMuebleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donacion_mueble', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_bienmueble')->unsigned();

            $table->string('institucion', 450)->nullable();
            $table->string('observaciones', 450)->nullable();
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
        Schema::dropIfExists('donacion_mueble');
    }
}
