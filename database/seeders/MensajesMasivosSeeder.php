<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MensajesMasivosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mensaje_masivos')->insert([
            ['titulo' => 'Promoción 1', 'contenido' => 'Contenido 1', 'area_id' => 1, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen1.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 2', 'contenido' => 'Contenido 2', 'area_id' => 2, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen2.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 3', 'contenido' => 'Contenido 3', 'area_id' => 3, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen3.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 4', 'contenido' => 'Contenido 4', 'area_id' => 4, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen4.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 5', 'contenido' => 'Contenido 5', 'area_id' => 5, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen5.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 6', 'contenido' => 'Contenido 6', 'area_id' => 6, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen6.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 7', 'contenido' => 'Contenido 7', 'area_id' => 7, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen7.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 8', 'contenido' => 'Contenido 8', 'area_id' => 8, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen8.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 9', 'contenido' => 'Contenido 9', 'area_id' => 9, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen9.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 10', 'contenido' => 'Contenido 10', 'area_id' => 10, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen10.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 11', 'contenido' => 'Contenido 11', 'area_id' => 11, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen11.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 12', 'contenido' => 'Contenido 12', 'area_id' => 12, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen12.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 13', 'contenido' => 'Contenido 13', 'area_id' => 13, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen13.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 14', 'contenido' => 'Contenido 14', 'area_id' => 14, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen14.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 15', 'contenido' => 'Contenido 15', 'area_id' => 15, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen15.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 16', 'contenido' => 'Contenido 16', 'area_id' => 16, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen16.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 17', 'contenido' => 'Contenido 17', 'area_id' => 17, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen17.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 18', 'contenido' => 'Contenido 18', 'area_id' => 18, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen18.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 19', 'contenido' => 'Contenido 19', 'area_id' => 19, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen19.jpg', 'estado' => 'borrador'],
            ['titulo' => 'Promoción 20', 'contenido' => 'Contenido 20', 'area_id' => 20, 'variables' => '{"nombre": "Cliente"}', 'ruta_imagen' => 'http://example.com/imagen20.jpg', 'estado' => 'borrador'],
        ]);
    }
}
