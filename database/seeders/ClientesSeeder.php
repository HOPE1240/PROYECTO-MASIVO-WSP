<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clientes')->insert([
            ['nombre' => 'Juan Pérez', 'telefono' => '123456789'],
            ['nombre' => 'Ana Gómez', 'telefono' => '987654321'],
            ['nombre' => 'Carlos López', 'telefono' => '456123789'],
            ['nombre' => 'María Fernández', 'telefono' => '789456123'],
            ['nombre' => 'Luis Martínez', 'telefono' => '321654987'],
            ['nombre' => 'Sofía Torres', 'telefono' => '654987321'],
            ['nombre' => 'Pedro Ramírez', 'telefono' => '987321654'],
            ['nombre' => 'Laura Sánchez', 'telefono' => '123789456'],
            ['nombre' => 'Diego Castro', 'telefono' => '456987123'],
            ['nombre' => 'Valeria Morales', 'telefono' => '789123654'],
            ['nombre' => 'Jorge Herrera', 'telefono' => '321987654'],
            ['nombre' => 'Camila Vargas', 'telefono' => '654123987'],
            ['nombre' => 'Andrés Rojas', 'telefono' => '987654123'],
            ['nombre' => 'Isabel Gutiérrez', 'telefono' => '123456987'],
            ['nombre' => 'Ricardo Peña', 'telefono' => '456789321'],
            ['nombre' => 'Gabriela Ruiz', 'telefono' => '789321456'],
            ['nombre' => 'Manuel Ortiz', 'telefono' => '321654123'],
            ['nombre' => 'Daniela Paredes', 'telefono' => '654987456'],
            ['nombre' => 'Fernando Silva', 'telefono' => '987123789'],
            ['nombre' => 'Paula Mendoza', 'telefono' => '123789987'],
        ]);
    }
}
