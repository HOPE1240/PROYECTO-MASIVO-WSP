<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagen_mensaje_masivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mensaje_masivo_id');
            $table->string('ruta');
            $table->timestamps(); 
            $table->foreign('mensaje_masivo_id')->references('id')->on('mensaje_masivos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imagen_mensaje_masivos');
    }
};
