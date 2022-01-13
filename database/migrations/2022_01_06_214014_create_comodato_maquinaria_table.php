<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComodatoMaquinariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comodato_maquinaria', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_bienvehiculo')->unsigned();

            $table->string('institucion', 450)->nullable();
            $table->string('observaciones', 450)->nullable();
            $table->string('documento', 100)->nullable();
            $table->date('fecha')->nullable();

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
        Schema::dropIfExists('comodato_maquinaria');
    }
}
