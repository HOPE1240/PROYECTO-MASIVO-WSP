<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogEnvioMasivosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('log_envio_masivos')->insert([
            ['mensaje_masivo_id' => 1, 'cliente_id' => 1, 'mensaje_final' => 'Hola Juan, promoción 1', 'estado' => 'enviado'],
            ['mensaje_masivo_id' => 2, 'cliente_id' => 2, 'mensaje_final' => 'Hola Ana, promoción 2', 'estado' => 'pendiente'],
            ['mensaje_masivo_id' => 3, 'cliente_id' => 3, 'mensaje_final' => 'Hola Pedro, promoción 3', 'estado' => 'enviado'],
            ['mensaje_masivo_id' => 4, 'cliente_id' => 4, 'mensaje_final' => 'Hola María, promoción 4', 'estado' => 'pendiente'],
            ['mensaje_masivo_id' => 5, 'cliente_id' => 5, 'mensaje_final' => 'Hola Luis, promoción 5', 'estado' => 'enviado'],
            ['mensaje_masivo_id' => 6, 'cliente_id' => 6, 'mensaje_final' => 'Hola Carla, promoción 6', 'estado' => 'pendiente'],
            ['mensaje_masivo_id' => 7, 'cliente_id' => 7, 'mensaje_final' => 'Hola Jorge, promoción 7', 'estado' => 'enviado'],
            ['mensaje_masivo_id' => 8, 'cliente_id' => 8, 'mensaje_final' => 'Hola Sofía, promoción 8', 'estado' => 'pendiente'],
            ['mensaje_masivo_id' => 9, 'cliente_id' => 9, 'mensaje_final' => 'Hola Andrés, promoción 9', 'estado' => 'enviado'],
            ['mensaje_masivo_id' => 10, 'cliente_id' => 10, 'mensaje_final' => 'Hola Laura, promoción 10', 'estado' => 'pendiente'],
            ['mensaje_masivo_id' => 11, 'cliente_id' => 11, 'mensaje_final' => 'Hola Diego, promoción 11', 'estado' => 'enviado'],
            ['mensaje_masivo_id' => 12, 'cliente_id' => 12, 'mensaje_final' => 'Hola Paula, promoción 12', 'estado' => 'pendiente'],
            ['mensaje_masivo_id' => 13, 'cliente_id' => 13, 'mensaje_final' => 'Hola Sergio, promoción 13', 'estado' => 'enviado'],
            ['mensaje_masivo_id' => 14, 'cliente_id' => 14, 'mensaje_final' => 'Hola Valeria, promoción 14', 'estado' => 'pendiente'],
            ['mensaje_masivo_id' => 15, 'cliente_id' => 15, 'mensaje_final' => 'Hola Martín, promoción 15', 'estado' => 'enviado'],
            ['mensaje_masivo_id' => 16, 'cliente_id' => 16, 'mensaje_final' => 'Hola Daniela, promoción 16', 'estado' => 'pendiente'],
            ['mensaje_masivo_id' => 17, 'cliente_id' => 17, 'mensaje_final' => 'Hola Gabriel, promoción 17', 'estado' => 'enviado'],
            ['mensaje_masivo_id' => 18, 'cliente_id' => 18, 'mensaje_final' => 'Hola Fernanda, promoción 18', 'estado' => 'pendiente'],
            ['mensaje_masivo_id' => 19, 'cliente_id' => 19, 'mensaje_final' => 'Hola Ricardo, promoción 19', 'estado' => 'enviado'],
            ['mensaje_masivo_id' => 20, 'cliente_id' => 20, 'mensaje_final' => 'Hola Natalia, promoción 20', 'estado' => 'pendiente'],
        ]);
    }
}
