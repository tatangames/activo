<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescargoMaquinariaTable extends Migration
{
    /**
     * lista de descargo de maquinaria
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descargo_maquinaria', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_bienvehiculo')->unsigned();

            $table->decimal('valor', 10,2)->nullable();
            $table->string('observaciones', 450)->nullable();
            $table->date('fecha')->nullable(); // fecha descargo

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
        Schema::dropIfExists('descargo_maquinaria');
    }
}
