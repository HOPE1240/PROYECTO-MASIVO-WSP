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
        // Elimina las foreign keys y columnas antes de eliminar la tabla areas
        Schema::table('mensajes_masivos', function (Blueprint $table) {
            if (Schema::hasColumn('mensajes_masivos', 'area_id')) {
                $table->dropForeign(['area_id']);
                $table->dropColumn('area_id');
            }
            if (Schema::hasColumn('mensajes_masivos', 'variables')) {
                $table->dropColumn('variables');
            }
        });

        // Elimina las tablas innecesarias
        Schema::dropIfExists('areas');
        Schema::dropIfExists('imagenes'); // O usa el nombre correcto de tu tabla de imágenes
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Aquí puedes agregar el código para revertir los cambios si lo necesitas
    }
};
