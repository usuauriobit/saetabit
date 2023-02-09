<?php

namespace Database\Seeders;

use App\Models\Tarjeta;
use Illuminate\Database\Seeder;

class TarjetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tarjeta::create(['descripcion' => 'VISA']);
        Tarjeta::create(['descripcion' => 'Mastercard']);
    }
}
