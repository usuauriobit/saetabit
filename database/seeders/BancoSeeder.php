<?php

namespace Database\Seeders;

use App\Models\Banco;
use Illuminate\Database\Seeder;

class BancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banco::create(['descripcion' => 'Banco Continental']);
        Banco::create(['descripcion' => 'Banco de Crédito']);
        Banco::create(['descripcion' => 'Banco de la Nación']);
    }
}
