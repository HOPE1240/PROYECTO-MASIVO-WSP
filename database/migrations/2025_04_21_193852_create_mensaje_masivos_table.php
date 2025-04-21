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
        Schema::create('mensaje_masivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_id');
            $table->string('titulo');
            $table->text('contenido');
            $table->json('variables')->nullable();
            $table->string('ruta_imagen')->nullable();
            $table->enum('estado', ['borrador', 'programado', 'enviado'])->default('borrador');
            $table->timestamp('fecha_programada')->nullable();
            $table->timestamps();
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mensaje_masivos');
    }
};
