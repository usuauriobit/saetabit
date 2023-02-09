<?php

namespace Database\Seeders;

use App\Models\Oficina;
use App\Models\Ubigeo;
use Illuminate\Database\Seeder;

class OficinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $oficinas = [
            [
                'ubigeo_id' => Ubigeo::whereDistrito('Tarapoto')->first()->id,
                'descripcion' => 'Tarapoto',
                'direccion' => 'Jr. Perú 536',
                'ruta_facturador' => 'https://api.nubefact.com/api/v1/d06a2f96-e9df-4349-a886-a9e1a707315b',
                'token_facturador' => '75327c74b4cc438eafbecc71243316c935071edfa0724d86a19a14ac0b48d6fd',
                // 'telefonos' => [
                //     '942476983'
                // ]
            ],
            [
                'ubigeo_id' => Ubigeo::whereDistrito('Yurimaguas')->first()->id,
                'descripcion' => 'Yurimaguas',
                'direccion' => 'Jr.Progeso 216',
                'ruta_facturador' => 'https://api.nubefact.com/api/v1/d06a2f96-e9df-4349-a886-a9e1a707315b',
                'token_facturador' => 'eb1d72d807d047748fe03be034838c02692ec46ad7564aadb74741e7d53ae20d',
                // 'telefonos' => [
                //     '942694482'
                // ]
            ],
            [
                'ubigeo_id' => Ubigeo::whereDistrito('Iquitos')->first()->id,
                'descripcion' => 'Iquitos',
                'direccion' => 'Carretera Iquitos Nauta139 San Juan Bautista',
                'ruta_facturador' => 'https://api.nubefact.com/api/v1/d06a2f96-e9df-4349-a886-a9e1a707315b',
                'token_facturador' => 'c1b14b8f3167499da90a431f3556ecf3498fb9d6a0224d048db1183794c3a186',
                // 'telefonos' => [
                //     '972657957'
                // ]
            ],
            [
                'ubigeo_id' => Ubigeo::whereDistrito('Pucallpa')->first()->id,
                'descripcion' => 'Pucallpa',
                'direccion' => 'Av.Aeropuerto Mz. C,Lote11B A.H.Los Cedros',
                'ruta_facturador' => 'https://api.nubefact.com/api/v1/d06a2f96-e9df-4349-a886-a9e1a707315b',
                'token_facturador' => '2271a31ab4cc47ecb24c0640e78cfc0971ea76610e6e49feb1f2b9591f7bd30a',
                // 'telefonos' => [
                //     '942711403'
                // ]
            ],
            [
                'ubigeo_id' => Ubigeo::whereDistrito('Chachapoyas')->first()->id,
                'descripcion' => 'Chachapoyas',
                'direccion' => 'Jr. Chachapoyas',
                // 'telefonos' => [
                //     '942977888'
                // ]
            ],
            [
                'ubigeo_id' => Ubigeo::whereDistrito('Atalaya')->first()->id,
                'descripcion' => 'Atalaya',
                'direccion' => 'Jr. Atalaya',
                // 'telefonos' => [
                //     '942977888'
                // ]
            ],
        ];

        foreach ($oficinas as $oficina) {
            $oficina_db = Oficina::create([
                'ubigeo_id' => $oficina['ubigeo_id'],
                'descripcion' => $oficina['descripcion'],
                'direccion' => $oficina['direccion'],
                'ruta_facturador' => $oficina['ruta_facturador'] ?? null,
                'token_facturador' => $oficina['token_facturador'] ?? null,
            ]);
            // foreach ($oficina['telefonos'] as $telefono) {
            //     $oficina_db->telefonos()->create(['nro_telefonico' => $telefono]);
            // }
        }
    }
}
