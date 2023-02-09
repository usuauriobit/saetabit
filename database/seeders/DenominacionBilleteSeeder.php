<?php

namespace Database\Seeders;

use App\Models\DenominacionBillete;
use Illuminate\Database\Seeder;

class DenominacionBilleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DenominacionBillete::create(['denominacion' => 'Billete de S/. 200.00', 'valor' => 200]);
        DenominacionBillete::create(['denominacion' => 'Billete de S/. 100.00', 'valor' => 100]);
        DenominacionBillete::create(['denominacion' => 'Billete de S/. 50.00', 'valor' => 50]);
        DenominacionBillete::create(['denominacion' => 'Billete de S/. 20.00', 'valor' => 20]);
        DenominacionBillete::create(['denominacion' => 'Billete de S/. 10.00', 'valor' => 10]);
        DenominacionBillete::create(['denominacion' => 'Moneda de S/. 5.00', 'valor' => 5]);
        DenominacionBillete::create(['denominacion' => 'Moneda de S/. 2.00', 'valor' => 2]);
        DenominacionBillete::create(['denominacion' => 'Moneda de S/. 1.00', 'valor' => 1]);
        DenominacionBillete::create(['denominacion' => 'Moneda de S/. 0.50', 'valor' => 0.50]);
        DenominacionBillete::create(['denominacion' => 'Moneda de S/. 0.20', 'valor' => 0.20]);
        DenominacionBillete::create(['denominacion' => 'Moneda de S/. 0.10', 'valor' => 0.10]);
    }
}
