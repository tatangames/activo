<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReevaluoInmuebleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reevaluo_inmueble', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_bieninmueble')->unsigned();
            $table->decimal('valornuevo', 10,2)->nullable();
            $table->string('observaciones', 450)->nullable();
            $table->date('fecha')->nullable();
            $table->string('documento', 100)->nullable();

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
        Schema::dropIfExists('reevaluo_inmueble');
    }
}
