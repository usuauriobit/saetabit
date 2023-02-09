<?php
namespace App\Services;

use App\Models\Cliente;
use App\Models\Persona;
use App\Models\TipoDocumento;
use App\Models\Ubigeo;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class PersonaService {
    public static function searchPersona($search){
        $persona = Persona::whereNroDoc($search)
                    ->orWhere(DB::raw("CONCAT('nombres',' ','apellido_paterno',' ','apellido_materno')"), $search)
                    ->first();
        if($persona) return $persona;

        $personaAPI = self::searchAPI('dni', $search);
        if(is_null($personaAPI)) return $personaAPI;


        $tipo_documento = TipoDocumento::whereDescripcion('Otro')->first();
        if(strlen($personaAPI['numero']) == 8)
            $tipo_documento = TipoDocumento::whereDescripcion('DNI')->first();
        if(strlen($personaAPI['numero']) == 11)
            $tipo_documento = TipoDocumento::whereDescripcion('RUC')->first();

        $nueva_persona = Persona::create([
            'nro_doc' => $personaAPI['numero'],
            'tipo_documento_id' => $tipo_documento->id,
            'ubigeo_id' => Ubigeo::whereCodigo($personaAPI['ubigeo_domicilio'])->first()->id ?? null,
            'lugar_nacimiento_id' => Ubigeo::whereCodigo($personaAPI['ubigeo_domicilio'])->first()->id ?? null,
            'apellido_paterno'  => $personaAPI['apellido_paterno'],
            'apellido_materno'  => $personaAPI['apellido_materno'],
            'nombres'           => $personaAPI['nombres'],
            'fecha_nacimiento'  => $personaAPI['fecha_nacimiento'],
            'sexo'              => $personaAPI['sexo'] == 'MASCULINO' ? 1 : 0
        ]);
        return $nueva_persona;
    }

    public static function searchEmpresa($search){
        $empresa = Cliente::where('ruc', 'LIKE', $search)
                ->orWhere('razon_social', 'LIKE', $search)
                ->orWhere('nombre_comercial', 'LIKE', $search)
                ->first();
        if($empresa) return $empresa;

        $empresaAPI = self::searchAPI('ruc', $search);
        if(!$empresaAPI || is_null($empresaAPI)) return $empresaAPI;

        // dd($empresaAPI);
        $nueva_empresa = Cliente::create([
            'ubigeo_id' => optional(Ubigeo::whereCodigo($empresaAPI['ubigeo'][2] ?? null)->first())->id ?? null,
            'ruc' => $empresaAPI['ruc'],
            'razon_social' => $empresaAPI['nombre_o_razon_social'],
            'nombre_comercial' => $empresaAPI['nombre_o_razon_social'],
            'descripcion' => '',
            'direccion' => $empresaAPI['direccion'] . ' - ' . $empresaAPI['dpd'] ?? '',
        ]);
        return $nueva_empresa;
    }

    public static function searchAPI($type, $nro_doc){
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://consulta.api-peru.com/',
            // You can set any number of default request options.
            // 'timeout'  => 2.0,
            'verify' => !config('app.debug'),
        ]);

        $response = $client->request('GET', "api/$type/$nro_doc", [
            'headers' => [
                "Authorization" => "Bearer 0e3ef92e68a879ea2a590e41e9b31664cb2785b3f80d1cd62331ed416f12e236"
            ]
        ]);
        $response = json_decode($response->getBody(), true);
        return $response['data'] ?? null;
    }
}
?>
