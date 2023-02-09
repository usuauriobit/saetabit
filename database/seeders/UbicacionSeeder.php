<?php

namespace Database\Seeders;

use App\Models\Ubicacion;
use App\Models\Ubigeo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UbicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $distritos = [
            [
                'distrito' => 'Pucallpa',
                'tipo_pista_id' => 1,
                'descripcion' => 'Aeropuerto Internacional Capitán FAP David Abensur Rengifo',
                'codigo_iata' => 'PCL',
                'codigo_icao' => 'SPCL',
            ],
            [
                'distrito' => 'Atalaya',
                'tipo_pista_id' => 2,
                'descripcion' => 'Aeródromo Tnte. Gral. Gerardo Pérez Pinedo',
                'codigo_iata' => '',
                'codigo_icao' => 'SPAY',
            ],
            [
                'distrito' => 'Rioja',
                'tipo_pista_id' => 2,
                'descripcion' => 'Aeródromo Juan Simons Vela',
                'codigo_iata' => 'RIJ',
                'codigo_icao' => 'SPJA',
            ],
            [
                'distrito' => 'Tarapoto',
                'tipo_pista_id' => 1,
                'descripcion' => 'Aeropuerto Cadete FAP Guillermo del Castillo Paredes',
                'codigo_iata' => 'TPP',
                'codigo_icao' => 'SPST',
            ],
            [
                'distrito' => 'Saposoa',
                'tipo_pista_id' => 2,
                'descripcion' => 'Aeródromo de Saposoa',
                'codigo_iata' => 'SFS',
                'codigo_icao' => 'SPOA',
            ],
            [
                'distrito' => 'Bellavista',
                'tipo_pista_id' => 2,
                'descripcion' => 'Aeródromo de Huallaga',
                'codigo_iata' => 'BLP',
                'codigo_icao' => 'SPBL',
            ],
            [
                'distrito' => 'Juanjui',
                'tipo_pista_id' => 1,
                'descripcion' => 'Aeropuerto de Juanjui',
                'codigo_iata' => 'JJI',
                'codigo_icao' => 'SPJI',
            ],
            [
                'distrito' => 'Tocache',
                'tipo_pista_id' => 2,
                'descripcion' => 'Aeródromo de Tocache',
                'codigo_iata' => 'TCG',
                'codigo_icao' => 'SPCH',

            ],
            [
                'distrito' => 'Contamana',
                'tipo_pista_id' => 2,
                'descripcion' => 'Aeródromo Contamana',
                'codigo_iata' => 'CTF',
                'codigo_icao' => 'SPCM',
            ],
            [
                'distrito' => 'Jaén',
                'tipo_pista_id' => 1,
                'descripcion' => 'Aeropuerto de Jaén',
                'codigo_iata' => 'JAE',
                'codigo_icao' => 'SPJE',
            ],
            [
                'distrito' => 'Yurimaguas',
                'tipo_pista_id' => 1,
                'descripcion' => 'Aeropuerto Moisés Benzaquen Rengifo',
                'codigo_iata' => 'YMS',
                'codigo_icao' => 'SPMS',
            ],
            [
                'distrito' => 'Iquitos',
                'tipo_pista_id' => 1,
                'descripcion' => 'Aeropuerto Internacional Coronel FAP Francisco Secada Vignetta',
                'codigo_iata' => 'IQT',
                'codigo_icao' => 'SPQT',
            ],
            [
                'distrito' => 'Andoas',
                'tipo_pista_id' => 1,
                'descripcion' => 'Aeropuerto Alf. FAP Alfredo Vladimir Sara Bauer',
                'codigo_iata' => '',
                'codigo_icao' => 'SPAS',
            ],
        ];

        foreach ($distritos as $ubicacion) {
            $ubigeo = Ubigeo::whereDistrito($ubicacion['distrito'])->first();
            Ubicacion::create([
                'ubigeo_id' => $ubigeo->id,
                'geo_latitud' => $ubigeo->geo_latitud,
                'geo_longitud' => $ubigeo->geo_longitud,
                'tipo_pista_id' => $ubicacion['tipo_pista_id'],
                'descripcion' => $ubicacion['descripcion'],
                'codigo_iata' => $ubicacion['codigo_iata'],
                'codigo_icao' => $ubicacion['codigo_icao'],
            ]);
        }
    }
}
