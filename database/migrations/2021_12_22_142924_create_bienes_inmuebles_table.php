<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBienesInmueblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bienes_inmuebles', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('id_estado')->unsigned();

            $table->integer('codigo')->nullable();
            $table->string('descripcion', 5000);
            $table->decimal('valor', 10, 2)->nullable();
            $table->string('ubicacion', 1000)->nullable();
            $table->string('documento', 100)->nullable();
            $table->string('inscrito', 100)->nullable();
            $table->decimal('valorregistrado', 10, 2)->nullable();
            $table->string('observaciones', 2000)->nullable();
            $table->date('fechacompra')->nullable();
            $table->string('contiene', 800)->nullable();
            $table->decimal('edificaciones', 10, 2)->nullable();
            $table->date('fechapermuta')->nullable();

            $table->foreign('id_estado')->references('id')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bienes_inmuebles');
    }
}
