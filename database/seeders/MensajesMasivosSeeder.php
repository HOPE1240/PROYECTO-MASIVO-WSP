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
            [
                'titulo' => '¡Oferta Especial!',
                'contenido' => 'Hola {{nombre}}, tenemos una promoción exclusiva para ti. Contáctanos al {{telefono}}.',
                'ruta_imagen' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
