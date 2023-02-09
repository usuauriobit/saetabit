<?php

namespace Database\Seeders;

use App\Models\CategoriaDescuento;
use App\Models\Descuento;
use App\Models\DescuentoClasificacion;
use App\Models\Ruta;
use App\Models\TipoDescuento;
use App\Models\TipoPasaje;
use App\Models\TipoVuelo;
use App\Models\Tramo;
use App\Models\Ubicacion;
use App\Services\TasaCambioService;
use Illuminate\Database\Seeder;

class DescuentoSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $string = file_get_contents(public_path()."/files/promociones.json");
        $json_a = json_decode($string, true);
        echo "Insertando promociones desde .json (Podría tardar un poco) \n";

        foreach ($json_a['data'] as $desc) {
            $data_tramo = [
                'origen_id' => Ubicacion::where('codigo_icao', "SP".$desc['ORIGEN'])->first()->id,
                'destino_id' => Ubicacion::where('codigo_icao', "SP".$desc['DESTINO'])->first()->id,
            ];
            $tramo_db = Tramo::updateOrCreate($data_tramo, $data_tramo);
            $rutas = Ruta::whereIsComercial()
                ->whereHas('tramo', function($q) use ($desc){
                    $q->whereHas('destino', function($q) use ($desc){
                        $q->where('codigo_icao', "SP".$desc['DESTINO']);
                    })->whereHas('origen', function($q) use ($desc){
                        $q->where('codigo_icao', "SP".$desc['ORIGEN']);
                    });
                })
                ->get();
            echo "SP".$desc['ORIGEN']." -- "."SP".$desc['DESTINO']." -- ".$desc['PRECIO']."\n";
            if(count($rutas) === 0){
                $ruta_db = Ruta::create([
                    'tipo_vuelo_id' => TipoVuelo::where('descripcion', 'Comercial')->first()->id,
                    'tramo_id' => $tramo_db->id,
                ]);
                $rutas = [$ruta_db];
            }

            foreach ($rutas as $ruta) {
                echo $desc['TIPO_PASAJE']."\n";

                $descripcion = 'Restante';
                if(is_int($desc['DIAS_ANTICIPACION']))
                    $descripcion = $desc['DIAS_ANTICIPACION']." días de anticipación";
                if(is_int($desc['ULTIMOS_CUPOS']))
                    $descripcion = "Últimos ".$desc['ULTIMOS_CUPOS']." cupos";
                if($desc['IS_IDA_VUELTA'] === 'si')
                    $descripcion = 'Ida y vuelta';
                if(is_int($desc['EDAD_MINIMA']))
                    $descripcion = 'De '.$desc['EDAD_MINIMA']." a ".$desc['EDAD_MAXIMA']." años";

                $clasificacion_descuento_descripcion = 'Regular';
                if(is_int($desc['DIAS_ANTICIPACION']))
                    $clasificacion_descuento_descripcion = 'Días de anticipación';
                if(is_int($desc['EDAD_MINIMA']))
                    $clasificacion_descuento_descripcion = 'Rango de edades';
                if(is_int($desc['ULTIMOS_CUPOS']))
                    $clasificacion_descuento_descripcion = 'Últimos cupos';

                Descuento::create([
                    'tipo_pasaje_id' => TipoPasaje::where('abreviatura', $desc['TIPO_PASAJE'])->first()->id,
                    // 'tipo_descuento_id' => $desc['IS_IDA_VUELTA'] === 'si' ? 1 : 2,
                    'tipo_descuento_id' => 2,
                    'descuento_clasificacion_id' => DescuentoClasificacion::whereDescripcion($clasificacion_descuento_descripcion)
                                                    ->first()->id,
                    'ruta_id' => $ruta->id,
                    'is_dolarizado' => !$ruta->is_subvencionado,
                    'is_automatico' => true,
                    // 'is_restante' => !isset($desc['DIAS_ANTICIPACION'])
                    //                     && !isset($desc['EDAD_MINIMA'])
                    //                     && !isset($desc['ULTIMOS_CUPOS'])
                    //                     && !isset($desc['IS_IDA_VUELTA']),
                    'categoria_descuento_id' => CategoriaDescuento::whereDescripcion('Monto fijo')->first()->id,
                    'descripcion'           => $descripcion,
                    'descuento_fijo'    => $ruta->is_subvencionado ? $desc['PRECIO'] : (new TasaCambioService())->getMontoDolares($desc['PRECIO']),
                    'dias_anticipacion' => is_int($desc['DIAS_ANTICIPACION']) ? $desc['DIAS_ANTICIPACION'] : null,
                    'fecha_expiracion'  => '2023-12-31',
                    // 'is_ultimos_cupos'  => isset($desc['ULTIMOS_CUPOS']),
                    // 'is_for_ida_vuelta' => $desc['IS_IDA_VUELTA'] === 'si',
                    'nro_maximo'        => $desc['PAX'],
                    'edad_minima'       => is_int($desc['EDAD_MINIMA']) ? $desc['EDAD_MINIMA'] : null,
                    'edad_maxima'       => is_int($desc['EDAD_MAXIMA']) ? $desc['EDAD_MAXIMA'] : null,
                ]);

                // PASAJE - INTERNO
                Descuento::create([
                    'ruta_id' => $ruta->id,
                    'descuento_clasificacion_id' => DescuentoClasificacion::whereDescripcion('Interno')->first()->id,
                    'tipo_pasaje_id'        => TipoPasaje::where('abreviatura', 'ADT')->first()->id,
                    'tipo_descuento_id'     => TipoDescuento::whereDescripcion('Pasaje')->first()->id,
                    'descripcion'           => 'Asuntos internos',
                    'descuento_porcentaje'  => null,
                    'descuento_fijo'        => 0,
                    'is_interno'            => true,
                    'categoria_descuento_id' => CategoriaDescuento::whereDescripcion('Monto fijo')->first()->id,
                    'is_dolarizado'         => true
                ]);
            }
        }
    }
}
