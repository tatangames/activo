<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBienesMueblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bienes_muebles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_departamento')->unsigned();
            $table->bigInteger('id_codcontable')->unsigned();
            $table->bigInteger('id_coddepreci')->unsigned();
            $table->bigInteger('id_descriptor')->unsigned();
            $table->bigInteger('id_tipocompra')->unsigned();

            $table->string('descripcion', 2000)->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->date('fechacompra')->nullable();
            $table->string('documento', 100)->nullable();
            $table->string('factura', 100)->nullable();
            $table->text('observaciones')->nullable();
            $table->integer('vidautil')->nullable();
            $table->integer('valresidual')->nullable();
            $table->integer('correlativo');

            $table->foreign('id_descriptor')->references('id')->on('descriptor');
            $table->foreign('id_coddepreci')->references('id')->on('codigo_depreciacion');
            $table->foreign('id_codcontable')->references('id')->on('codigo_contable');
            $table->foreign('id_departamento')->references('id')->on('departamento');
            $table->foreign('id_tipocompra')->references('id')->on('tipo_compra');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bienes_muebles');
    }
}