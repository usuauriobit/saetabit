<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UbigeoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $string = file_get_contents(public_path()."/files/ubigeo.json");
        $json_a = json_decode($string, true);
        echo "Insertando ubigeo desde .json (Podría tardar un poco) \n";

        foreach ($json_a['ubigeo_reniec'] as $key => $ubi) {
            \DB::table('ubigeos')->insert([
                'codigo' => $ubi['Ubigeo'],
                'distrito' => $ubi['Distrito'],
                'provincia' => $ubi['Provincia'],
                'departamento' => $ubi['Departamento'],
                'geo_latitud' => $ubi['Y'],
                'geo_longitud' => $ubi['X'],
            ]);
        }
    }
}
