<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            ['nombre' => 'Marketing'],
            ['nombre' => 'Ventas'],
            ['nombre' => 'Soporte'],
            ['nombre' => 'Recursos Humanos'],
            ['nombre' => 'Finanzas'],
            ['nombre' => 'Operaciones'],
            ['nombre' => 'Logística'],
            ['nombre' => 'Producción'],
            ['nombre' => 'Investigación'],
            ['nombre' => 'Desarrollo'],
            ['nombre' => 'Compras'],
            ['nombre' => 'Atención al Cliente'],
            ['nombre' => 'Calidad'],
            ['nombre' => 'Legal'],
            ['nombre' => 'Administración'],
            ['nombre' => 'TI'],
            ['nombre' => 'Seguridad'],
            ['nombre' => 'Mantenimiento'],
            ['nombre' => 'Proyectos'],
            ['nombre' => 'Innovación'],
        ]);
    }
}
