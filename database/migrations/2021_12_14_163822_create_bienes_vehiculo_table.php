<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBienesVehiculoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bienes_vehiculo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_tipocompra')->unsigned();
            $table->bigInteger('id_coddepreci')->unsigned();
            $table->bigInteger('id_codcontable')->unsigned();
            $table->bigInteger('id_departamento')->unsigned();
            $table->bigInteger('id_estado')->unsigned();

            $table->string('descripcion', 5000);
            $table->decimal('valor', 10, 2)->nullable();
            $table->string('placa', 50)->nullable();
            $table->string('motorista', 150)->nullable();
            $table->integer('vidautil')->nullable();
            $table->date('fechacompra')->nullable();
            $table->integer('anio')->nullable();
            $table->date('fechavectar')->nullable();
            $table->string('encargado', 150)->nullable();
            $table->integer('valresidual')->nullable();
            $table->string('observaciones', 2000)->nullable();

            $table->integer('codigo')->nullable();
            $table->string('documento', 100)->nullable();

            $table->foreign('id_tipocompra')->references('id')->on('tipo_compra');
            $table->foreign('id_coddepreci')->references('id')->on('codigo_depreciacion');
            $table->foreign('id_codcontable')->references('id')->on('codigo_contable');
            $table->foreign('id_departamento')->references('id')->on('departamento');
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
        Schema::dropIfExists('bienes_vehiculo');
    }
}
