<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSustitucionMuebleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sustitucion_mueble', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_bienmueble')->unsigned();

            $table->decimal('piezasustituida', 10,2)->nullable();
            $table->decimal('valorajustado', 10,2)->nullable();
            $table->decimal('piezanueva', 10,2)->nullable();
            $table->integer('vidautil')->nullable();
            $table->string('observaciones', 450)->nullable();
            $table->date('fecha')->nullable();
            $table->string('documento', 100)->nullable();

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
        Schema::dropIfExists('sustitucion_mueble');
    }
}
