<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagenMensajeMasivosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('imagen_mensaje_masivos')->insert([
            ['mensaje_masivo_id' => 1, 'ruta' => 'http://example.com/imagen1.jpg'],
            ['mensaje_masivo_id' => 2, 'ruta' => 'http://example.com/imagen2.jpg'],
            ['mensaje_masivo_id' => 3, 'ruta' => 'http://example.com/imagen3.jpg'],
            ['mensaje_masivo_id' => 4, 'ruta' => 'http://example.com/imagen4.jpg'],
            ['mensaje_masivo_id' => 5, 'ruta' => 'http://example.com/imagen5.jpg'],
            ['mensaje_masivo_id' => 6, 'ruta' => 'http://example.com/imagen6.jpg'],
            ['mensaje_masivo_id' => 7, 'ruta' => 'http://example.com/imagen7.jpg'],
            ['mensaje_masivo_id' => 8, 'ruta' => 'http://example.com/imagen8.jpg'],
            ['mensaje_masivo_id' => 9, 'ruta' => 'http://example.com/imagen9.jpg'],
            ['mensaje_masivo_id' => 10, 'ruta' => 'http://example.com/imagen10.jpg'],
            ['mensaje_masivo_id' => 11, 'ruta' => 'http://example.com/imagen11.jpg'],
            ['mensaje_masivo_id' => 12, 'ruta' => 'http://example.com/imagen12.jpg'],
            ['mensaje_masivo_id' => 13, 'ruta' => 'http://example.com/imagen13.jpg'],
            ['mensaje_masivo_id' => 14, 'ruta' => 'http://example.com/imagen14.jpg'],
            ['mensaje_masivo_id' => 15, 'ruta' => 'http://example.com/imagen15.jpg'],
            ['mensaje_masivo_id' => 16, 'ruta' => 'http://example.com/imagen16.jpg'],
            ['mensaje_masivo_id' => 17, 'ruta' => 'http://example.com/imagen17.jpg'],
            ['mensaje_masivo_id' => 18, 'ruta' => 'http://example.com/imagen18.jpg'],
            ['mensaje_masivo_id' => 19, 'ruta' => 'http://example.com/imagen19.jpg'],
            ['mensaje_masivo_id' => 20, 'ruta' => 'http://example.com/imagen20.jpg'],
        ]);
    }
}
