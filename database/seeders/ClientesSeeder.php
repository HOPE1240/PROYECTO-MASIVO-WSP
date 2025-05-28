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
        // Primer cliente real
        DB::table('clientes')->insert([
            [
                'nombre' => 'Santiago Garcia Uribe',
                'telefono' => '3245868817',
            ]
        ]);

        // 1999 clientes ficticios
        $clientes = [];
        for ($i = 2; $i <= 2000; $i++) {
            $clientes[] = [
                'nombre' => 'Cliente ' . $i,
                'telefono' => '300000' . str_pad($i, 4, '0', STR_PAD_LEFT),
            ];
        }
        // Inserta en bloques para eficiencia
        foreach (array_chunk($clientes, 500) as $chunk) {
            DB::table('clientes')->insert($chunk);
        }
    }
}
