<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialModificacionTable extends Migration
{
    /**
     * Guarda modificaciones del sistema con el usuario que lo hizo
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_modificacion', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_usuario')->unsigned();
            $table->string('detalle', 300);
            $table->dateTime('fecha');

            $table->foreign('id_usuario')->references('id')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_modificacion');
    }
}
