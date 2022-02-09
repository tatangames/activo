<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBienesInmueblesTable extends Migration
{
    /**
     * bienes inmuebles
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bienes_inmuebles', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('id_estado')->unsigned();

            $table->integer('codigo')->nullable();
            $table->text('descripcion');
            $table->decimal('valor', 15, 2)->nullable();
            $table->text('ubicacion')->nullable();
            $table->string('documento', 100)->nullable();
            $table->string('inscrito', 100)->nullable();
            $table->decimal('valorregistrado', 15, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->date('fechacompra')->nullable();
            $table->text('contiene')->nullable();
            $table->decimal('edificaciones', 15, 2)->nullable();
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
