<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodigoContableTable extends Migration
{
    /**
     * codigos contable
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigo_contable', function (Blueprint $table) {
            $table->id();
            $table->integer('codconta')->nullable();
            $table->string('nombre', 350);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codigo_contable');
    }
}
