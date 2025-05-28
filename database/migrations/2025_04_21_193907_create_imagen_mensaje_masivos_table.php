<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Elimina la foreign key y columna area_id, y los campos innecesarios
        Schema::table('mensaje_masivos', function (Blueprint $table) {
            if (Schema::hasColumn('mensaje_masivos', 'area_id')) {
                $table->dropForeign(['area_id']);
                $table->dropColumn('area_id');
            }
            if (Schema::hasColumn('mensaje_masivos', 'variables')) {
                $table->dropColumn('variables');
            }
            if (Schema::hasColumn('mensaje_masivos', 'estado')) {
                $table->dropColumn('estado');
            }
            if (Schema::hasColumn('mensaje_masivos', 'fecha_programada')) {
                $table->dropColumn('fecha_programada');
            }
        });

        // Elimina las tablas innecesarias
        Schema::dropIfExists('areas');
        Schema::dropIfExists('imagenes');
    }

    public function down()
    {
        // Aquí puedes agregar el código para revertir los cambios si lo necesitas
    }
};
