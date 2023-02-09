<?php

namespace Database\Seeders;

use App\Models\TarifaBulto;
use App\Models\TipoVuelo;
use Illuminate\Database\Seeder;

class TarifaBultoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TarifaBulto::create([
            'tipo_vuelo_id'     => TipoVuelo::whereDescripcion('Comercial')->first()->id,
            'peso_max'          => 10,
            'monto_kg_excedido' => 4,
            'tipo_bulto_id'     => 1,
            'is_monto_editable' => false,
            'is_monto_fijo' => false,
            'is_equipaje'   => true,
        ]);
        TarifaBulto::create([
            'tipo_vuelo_id'     => TipoVuelo::whereDescripcion('Comercial')->first()->id,
            'peso_max'          => 0,
            'monto_kg_excedido' => 10,
            'tipo_bulto_id'     => 2,
            'is_monto_editable' => true,
            'is_monto_fijo' => true,
            'is_equipaje'   => true,
        ]);
        TarifaBulto::create([
            'tipo_vuelo_id'     => TipoVuelo::whereDescripcion('Comercial')->first()->id,
            'peso_max'          => 0,
            'monto_kg_excedido' => 55,
            'tipo_bulto_id'     => 3,
            'is_monto_editable' => true,
            'is_monto_fijo' => true,
            'is_equipaje'   => false,
        ]);
        TarifaBulto::create([
            'tipo_vuelo_id'     => TipoVuelo::whereDescripcion('Subvencionado')->first()->id,
            'peso_max'          => 5,
            'monto_kg_excedido' => 8,
            'tipo_bulto_id'     => 1,
            'is_monto_editable' => false,
            'is_monto_fijo' => false,
            'is_equipaje'   => true,
        ]);
        TarifaBulto::create([
            'tipo_vuelo_id'     => TipoVuelo::whereDescripcion('Subvencionado')->first()->id,
            'peso_max'          => 0,
            'monto_kg_excedido' => 10,
            'tipo_bulto_id'     => 2,
            'is_monto_editable' => true,
            'is_monto_fijo' => true,
            'is_equipaje'   => true,
        ]);
        TarifaBulto::create([
            'tipo_vuelo_id'     => TipoVuelo::whereDescripcion('Subvencionado')->first()->id,
            'peso_max'          => 0,
            'monto_kg_excedido' => 55,
            'tipo_bulto_id'     => 3,
            'is_monto_editable' => true,
            'is_monto_fijo' => true,
            'is_equipaje'   => false,
        ]);
        TarifaBulto::create([
            'tipo_vuelo_id'     => TipoVuelo::whereDescripcion('No regular')->first()->id,
            'peso_max'          => 5,
            'monto_kg_excedido' => 8,
            'tipo_bulto_id'     => 1,
            'is_monto_editable' => false,
            'is_monto_fijo' => false,
            'is_equipaje'   => true,
        ]);
        TarifaBulto::create([
            'tipo_vuelo_id'     => TipoVuelo::whereDescripcion('No regular')->first()->id,
            'peso_max'          => 0,
            'monto_kg_excedido' => 10,
            'tipo_bulto_id'     => 2,
            'is_monto_editable' => true,
            'is_monto_fijo' => true,
            'is_equipaje'   => true,
        ]);
        TarifaBulto::create([
            'tipo_vuelo_id'     => TipoVuelo::whereDescripcion('No regular')->first()->id,
            'peso_max'          => 0,
            'monto_kg_excedido' => 55,
            'tipo_bulto_id'     => 3,
            'is_monto_editable' => true,
            'is_monto_fijo' => true,
            'is_equipaje'   => false,
        ]);
    }
}
