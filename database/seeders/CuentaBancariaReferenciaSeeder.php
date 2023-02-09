<?php

namespace Database\Seeders;

use App\Models\CuentaBancariaReferencial;
use Illuminate\Database\Seeder;

class CuentaBancariaReferenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CuentaBancariaReferencial::create([
            'nro_cuenta'         => '123123123123',
            'descripcion_cuenta' => 'Cuenta Bancaria de prueba',
            'glosa'              => 'Cuenta de prueba',
        ]);
    }
}
