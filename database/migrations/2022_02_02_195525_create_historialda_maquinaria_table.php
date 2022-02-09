<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialdaMaquinariaTable extends Migration
{
    /**
     * lista de historialda maquinaria
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historialda_maquinaria', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_bienvehiculo')->unsigned();
            $table->decimal('vallibros', 10, 2)->nullable();
            $table->decimal('depanual', 10, 2)->nullable();
            $table->decimal('depacumulada', 10, 2)->nullable();
            $table->integer('anio')->nullable();

            $table->foreign('id_bienvehiculo')->references('id')->on('bienes_vehiculo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historialda_maquinaria');
    }
}
