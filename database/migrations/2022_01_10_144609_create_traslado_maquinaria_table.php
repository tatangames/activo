<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrasladoMaquinariaTable extends Migration
{
    /**
     * lista de traslado maquinaria
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traslado_maquinaria', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_bienvehiculo')->unsigned();
            $table->bigInteger('id_deptoenvia')->unsigned();
            $table->bigInteger('id_deptorecibe')->unsigned();
            $table->date('fechatraslado')->nullable();

            $table->foreign('id_bienvehiculo')->references('id')->on('bienes_vehiculo');
            $table->foreign('id_deptoenvia')->references('id')->on('departamento');
            $table->foreign('id_deptorecibe')->references('id')->on('departamento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('traslado_maquinaria');
    }
}
