<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodigoDepreciacionTable extends Migration
{
    /**
     * codigo depreciacion
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigo_depreciacion', function (Blueprint $table) {
            $table->id();
            $table->integer('coddepre')->nullable();
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
        Schema::dropIfExists('codigo_depreciacion');
    }
}
