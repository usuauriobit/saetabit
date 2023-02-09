<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NacionalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $string = file_get_contents(public_path()."/files/nacionalidades.json");
        $json_a = json_decode($string, true);
        echo "Insertando nacionalidades desde .json (Podría tardar un poco) \n";

        foreach ($json_a as $key => $ubi) {
            \DB::table('nacionalidads')->insert([
                'descripcion' => $ubi['nombre'],
                'iso2' => $ubi['iso2'],
                'iso3' => $ubi['iso3'],
                'phone_code' => $ubi['phone_code'],
            ]);
        }
    }
}
