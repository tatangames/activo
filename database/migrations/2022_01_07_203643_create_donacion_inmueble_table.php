<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonacionInmuebleTable extends Migration
{
    /**
     * listado de donacion inmueble
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donacion_inmueble', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_bieninmueble')->unsigned();

            $table->string('institucion', 450)->nullable();
            $table->string('observaciones', 450)->nullable();
            $table->string('documento', 100)->nullable();
            $table->date('fecha')->nullable();

            $table->foreign('id_bieninmueble')->references('id')->on('bienes_inmuebles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donacion_inmueble');
    }
}
