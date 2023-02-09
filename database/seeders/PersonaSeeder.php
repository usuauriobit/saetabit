<?php

namespace Database\Seeders;

use App\Models\Oficina;
use App\Models\Persona;
use App\Models\Personal;
use App\Models\TipoDocumento;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = Faker::create();
        // for ($i = 0; $i < 60; $i++) {
        //     \DB::table('personas')->insert(array(
        //         'apellido_paterno' => $faker->lastName,
        //         'apellido_materno' => $faker->lastName,
        //         'nombres' => $faker->firstName,
        //     ));
        // }

        $string = file_get_contents(public_path()."/files/usuarios.json");
        $json_a = json_decode($string, true);
        echo "Insertando usuarios desde .json (Podría tardar un poco) \n";

        foreach ($json_a as $key => $value) {

            $oficina = Oficina::whereDescripcion($value['oficina'])->first();

            if ($oficina) {
                $persona = Persona::create([
                    'tipo_documento_id' => TipoDocumento::whereDescripcion('DNI')->first()->id,
                    'apellido_paterno' => $value['apellido_paterno'],
                    'apellido_materno' => $value['apellido_materno'],
                    'nombres' => $value['nombre'],
                    'nro_doc' => $value['dni'],
                ]);

                $personal = Personal::create([
                    'oficina_id' => $oficina->id,
                    'persona_id' => $persona->id,
                    'fecha_ingreso' => date('Y-m-d')
                ]);

                $user = User::create([
                    'email' => $value['user'] . '@saeta.com',
                    'personal_id' => $personal->id,
                    'password' => Hash::make($value['user'])
                ]);

                $user->assignRole($value['rol']);
            }

        }
    }
}
