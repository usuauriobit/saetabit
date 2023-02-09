<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clientes')->insert([
            'ruc' => '20131379944',
            'razon_social' => 'Ministerio de Transportes y Comunicaciones',
            'user_created_id' => 1
        ]);
    }
}
