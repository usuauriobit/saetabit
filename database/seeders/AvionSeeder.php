<?php

namespace Database\Seeders;

use App\Models\Avion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AvionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auth::loginUsingId(1);
        $string = file_get_contents(public_path()."/files/aviones.json");
        $json_a = json_decode($string, true);
        echo "Insertando ubigeo desde .json (Podría tardar un poco) \n";

        foreach ($json_a as $key => $avion) {
            \DB::table('avions')->insert([
                'matricula' => $avion['Matricula'],
                'descripcion' => $avion['Descripcion'],
                'peso_max_pasajeros' => $avion['PesoPax'],
                'peso_max_carga' => $avion['PesoCarga'],
                'nro_asientos' => $avion['Asientos']
            ]);
        }
    }
}
