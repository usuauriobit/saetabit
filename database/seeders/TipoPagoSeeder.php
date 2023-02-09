<?php

namespace Database\Seeders;

use App\Models\TipoPago;
use Illuminate\Database\Seeder;

class TipoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPago::create(['descripcion' => 'Efectivo']);
        TipoPago::create(['descripcion' => 'Tarjeta de Crédito o Débito']);
        TipoPago::create(['descripcion' => 'Transferencia Bancaria']);
        TipoPago::create(['descripcion' => 'Crédito']);
    }
}
