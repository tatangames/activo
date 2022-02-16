<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescriptorTable extends Migration
{
    /**
     * descriptores
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descriptor', function (Blueprint $table) {
            $table->id();
            $table->integer('codigodes')->nullable();
            $table->string('descripcion', 350);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('descriptor');
    }
}
