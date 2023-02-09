<?php

namespace Database\Seeders;

use App\Models\Oficina;
use App\Models\OficinaCuentaBancaria;
use Illuminate\Database\Seeder;

class OficinaCuentaBancariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $oficina = Oficina::whereDescripcion('Tarapoto')->first();

        OficinaCuentaBancaria::create([
            'oficina_id' => $oficina->id,
            'banco_id' => 1,
            'nro_cuenta' => '001-002-1872872383',
            'nro_cci' => '10-001-002-1872872383-3',
        ]);
    }
}
