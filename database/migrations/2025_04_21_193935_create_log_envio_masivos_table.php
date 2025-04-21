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
        Schema::create('log_envio_masivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mensaje_masivo_id');
            $table->unsignedBigInteger('cliente_id');
            $table->text('mensaje_final');
            $table->enum('estado', ['pendiente', 'enviado', 'error'])->default('pendiente');
            $table->text('error')->nullable();
            $table->timestamp('enviado_en')->nullable();
            $table->timestamps();
            $table->foreign('mensaje_masivo_id')->references('id')->on('mensaje_masivos')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_envio_masivos');
    }
};
