<?php

namespace Database\Seeders;

use App\Models\TipoDocumento;
use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        TipoDocumento::create(['descripcion' => 'DNI', 'codigo' => '1']);
        TipoDocumento::create(['descripcion' => 'RUC', 'codigo' => '6']);
        TipoDocumento::create(['descripcion' => 'Pasaporte', 'codigo' => '7']);
        TipoDocumento::create(['descripcion' => 'Carnet de extranjería', 'codigo' => '4']);
        // TipoDocumento::create(['descripcion' => 'Cédula de identidad', 'codigo' => 'A']);
        TipoDocumento::create(['descripcion' => 'Permiso temporal de permanencia', 'codigo' => '-']);
        TipoDocumento::create(['descripcion' => 'Documento extranjero', 'codigo' => '-']);
        TipoDocumento::create(['descripcion' => 'Sin documento', 'codigo' => '-']);
        TipoDocumento::create(['descripcion' => 'Otro', 'codigo' => '-']);
    }
}
