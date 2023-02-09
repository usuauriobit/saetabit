<?php

namespace Database\Seeders;

use App\Models\Oficina;
use App\Models\Persona;
use App\Models\Personal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $persona = \DB::table('personas')->insert([
            'ubigeo_id' => 1,
            'lugar_nacimiento_id' => 1,
            'nombres' => 'Anthony Will',
            'apellido_paterno' => 'Solsol',
            'apellido_materno' => 'Soplin',
        ]);
        $personal = \DB::table('personals')->insert([
            'oficina_id' => 1,
            'persona_id' => 1,
        ]);

        $user = User::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'personal_id' => 1,
        ]);

        $user->assignRole(['Administrador']);





        // $persona = \DB::table('personas')->insert([
        //     'ubigeo_id' => 1,
        //     'lugar_nacimiento_id' => 1,
        //     'nombres' => 'Jose Luis',
        //     'apellido_paterno' => 'Chong',
        //     'apellido_materno' => 'Sanchez',
        // ]);
        // $personal = \DB::table('personals')->insert([
        //     'oficina_id' => 1,
        //     'persona_id' => 1,
        // ]);

        // $user = User::create([
        //     'email' => 'user_prueba@gmail.com',
        //     'password' => Hash::make('prueba2022'),
        //     'personal_id' => 1,
        // ]);

        // $user->assignRole(['Administrador']);
    }
}
