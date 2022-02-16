<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialModificacionTabla extends Migration
{
    /**
     *
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_modificacion_tabla', function (Blueprint $table) {
            $table->id();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_modificacion_tabla');
    }
}
