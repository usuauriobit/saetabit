<?php

namespace App\Services;

use App\Models\ComprobanteFacturacionRespuesta;
use App\Models\CajaTipoComprobante;
use App\Models\Comprobante;
use Illuminate\Support\Str;
use App\Models\Oficina;
use Carbon\Carbon;

class FacturacionService
{
    static function enviarJson($comprobante, $tipo)
    {
        switch ($tipo) {
            case 'generar_comprobante':
                    $data_json = self::generarJson($comprobante, $tipo);
                break;
            case 'generar_anulacion':
                    $data_json = self::generarAnulacionJson($comprobante, $tipo);
                break;
            default:
                # code...
                break;
        }

        $oficina = Oficina::find($comprobante->caja->oficina_id);
        // dd($data_json);
        $respuesta = self::consumirApi($oficina, $data_json);

        self::leerRespuesta(json_decode($respuesta, true), $comprobante);
    }

    static function consumirApi($oficina, $data_json)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $oficina->ruta_facturador);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Token token="'.$oficina->token_facturador.'"',
                'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta  = curl_exec($ch);
        curl_close($ch);

        return $respuesta;
    }

    static function leerRespuesta($leer_respuesta, $comprobante)
    {
        if (isset($leer_respuesta['errors'])) {
            $comprobante->respuestas()->create([ 'errors' => $leer_respuesta['errors'] ]);
        } else {
            $comprobante->respuestas()->create([
                'tipo_de_comprobante' => isset($leer_respuesta['tipo_de_comprobante']) ? $leer_respuesta['tipo_de_comprobante'] : "",
                'serie' => isset($leer_respuesta['serie']) ? $leer_respuesta['serie'] : "",
                'numero' => isset($leer_respuesta['numero']) ? $leer_respuesta['numero'] : "",
                'enlace' => isset($leer_respuesta['enlace']) ? $leer_respuesta['enlace'] : "",
                'enlace_del_pdf' => isset($leer_respuesta['enlace_del_pdf']) ? $leer_respuesta['enlace_del_pdf'] : "",
                'enlace_del_xml' => isset($leer_respuesta['enlace_del_xml']) ? $leer_respuesta['enlace_del_xml'] : "",
                'enlace_del_cdr' => isset($leer_respuesta['enlace_del_cdr']) ? $leer_respuesta['enlace_del_cdr'] : "",
                'aceptada_por_sunat' => isset($leer_respuesta['aceptada_por_sunat']) ? $leer_respuesta['aceptada_por_sunat'] : "",
                'sunat_description' => isset($leer_respuesta['sunat_description']) ? $leer_respuesta['sunat_description'] : "",
                'sunat_note' => isset($leer_respuesta['sunat_note']) ? $leer_respuesta['sunat_note'] : "",
                'sunat_responsecode' => isset($leer_respuesta['sunat_responsecode']) ? $leer_respuesta['sunat_responsecode'] : "",
                'sunat_soap_error' => isset($leer_respuesta['sunat_soap_error']) ?  $leer_respuesta['sunat_soap_error'] : "",
                'cadena_para_codigo_qr' => isset($leer_respuesta['cadena_para_codigo_qr']) ?  $leer_respuesta['cadena_para_codigo_qr'] : "",
                'codigo_hash' => isset($leer_respuesta['codigo_hash']) ? $leer_respuesta['codigo_hash'] : "",
            ]);
        }
    }

    static function generarJson($comprobante, $tipo)
    {
        $data = array(
            "operacion"				            => $tipo,
            "tipo_de_comprobante"               => $comprobante->tipo_comprobante->codigo,
            "serie"                             => $comprobante->serie,
            "numero"				            => $comprobante->correlativo_sin_ceros,
            "sunat_transaction"			        => "1",
            "cliente_tipo_de_documento"		    => $comprobante->tipo_documento->codigo,
            "cliente_numero_de_documento"	    => $comprobante->nro_documento,
            "cliente_denominacion"              => $comprobante->denominacion,
            "cliente_direccion"                 => $comprobante->direccion,
            "cliente_email"                     => "",
            "cliente_email_1"                   => "",
            "cliente_email_2"                   => "",
            "fecha_de_emision"                  => date('d-m-Y'),
            "fecha_de_vencimiento"              => "",
            "moneda"                            => $comprobante->moneda->codigo,
            "tipo_de_cambio"                    => "",
            "porcentaje_de_igv"                 => "18.00",
            "descuento_global"                  => "",
            "descuento_global"                  => "",
            "total_descuento"                   => "",
            "total_anticipo"                    => "",
            "total_gravada"                     => "0",
            "total_inafecta"                    => "",
            "total_exonerada"                   => $comprobante->total_importe,
            "total_igv"                         => "0",
            "total_gratuita"                    => "",
            "total_otros_cargos"                => "",
            "total"                             => $comprobante->total_importe,
            "percepcion_tipo"                   => "1",
            "percepcion_base_imponible"         => "",
            "total_percepcion"                  => "",
            "total_incluido_percepcion"         => "",
            "detraccion"                        => "false",
            "observaciones"                     => $comprobante->observaciones,
            "documento_que_se_modifica_tipo"    => isset($comprobante->comprobante_modifica) ? $comprobante->comprobante_modifica->tipo_comprobante->codigo : "",
            "documento_que_se_modifica_serie"   => isset($comprobante->comprobante_modifica) ? $comprobante->comprobante_modifica->serie : "",
            "documento_que_se_modifica_numero"  => isset($comprobante->comprobante_modifica) ? $comprobante->comprobante_modifica->correlativo_sin_ceros : "",
            "tipo_de_nota_de_credito"           => isset($comprobante->comprobante_modifica) ? $comprobante->tipo_nota_credito->codigo : "",
            "tipo_de_nota_de_debito"            => "",
            "enviar_automaticamente_a_la_sunat" => "true",
            "enviar_automaticamente_al_cliente" => "false",
            "codigo_unico"                      => "",
            "condiciones_de_pago"               => "",
            "medio_de_pago"                     => $comprobante->tipo_pago->descripcion == 'Crédito' ? "venta_al_credito" : "",
            "placa_vehiculo"                    => "",
            "orden_compra_servicio"             => "",
            "tabla_personalizada_codigo"        => "",
            "formato_de_pdf"                    => self::obtenerFormatoPdf($comprobante),
        );

        $detalles = isset($comprobante->comprobante_modifica)
                    ? $comprobante->comprobante_modifica->detalles
                    : $comprobante->detalles;

        foreach ($detalles as $detalle) {
            $data['items'][] = array(
                "unidad_de_medida"          => "ZZ",
                "codigo"                    => "",
                "descripcion"               => $detalle->descripcion,
                "cantidad"                  => $detalle->cantidad,
                "valor_unitario"            => $detalle->precio_unitario,
                "precio_unitario"           => $detalle->precio_unitario,
                "descuento"                 => "",
                "subtotal"                  => $detalle->importe,
                "tipo_de_igv"               => "8",
                "igv"                       => "0",
                "total"                     => $detalle->importe,
                "anticipo_regularizacion"   => "false",
                "anticipo_documento_serie"  => "",
                "anticipo_documento_numero" => ""
            );
        }

        if ($comprobante->tipo_pago->descripcion == 'Crédito') {
            // $date = Carbon::createFromFormat('Y-m-d', $comprobante->fecha_credito->format('Y-m-d'));
            // for ($i=1; $i <= $comprobante->nro_cuotas; $i++) {
            //     $data['venta_al_credito'][] = array(
            //         "cuota" => $i,
            //         "fecha_de_pago" => $date->addMonth(1)->format('d-m-Y'),
            //         "importe" => round($comprobante->total_importe / $comprobante->nro_cuotas, 2),
            //     );
            // }
            foreach ($comprobante->cuotas as $cuota) {
                $data['venta_al_credito'][] = array(
                    "cuota" => $cuota->nro_cuota,
                    "fecha_de_pago" => $cuota->fecha_pago->format('d-m-Y'),
                    "importe" => $cuota->importe,
                );
            }
        }

        return json_encode($data);
    }

    static function generarAnulacionJson($comprobante, $tipo)
    {
        $data = array(
            "operacion"				            => $tipo,
            "tipo_de_comprobante"               => $comprobante->tipo_comprobante->codigo,
            "serie"                             => $comprobante->serie,
            "numero"				            => $comprobante->correlativo_sin_ceros,
            "motivo"                            => "ERROR DEL SISTEMA",
            "codigo_unico"                      => ""
        );

        return json_encode($data);
    }

    static function obtenerCorrelativo($tipo_comprobante_id, $caja_id, $comprobante_modifica = null)
    {
        $data = [];

        $caja_tipo_comprobante = CajaTipoComprobante::whereTipoComprobanteId($tipo_comprobante_id)
                                                ->whereCajaId($caja_id)
                                                ->first();

        if ($caja_tipo_comprobante) {
            $serie = (isset($comprobante_modifica)) ? $comprobante_modifica->serie : $caja_tipo_comprobante->serie;
            $correlativos = Comprobante::withTrashed()->whereCajaId($caja_id)->whereSerie($serie)->get(['correlativo'])
                            ->pluck('correlativo');

            $correlativo =  Str::padLeft($correlativos->max() + 62, 6, '0');

            $data = [
                'serie' => $serie,
                'correlativo' => $correlativo,
            ];
        }

        return $data;
    }

    static function obtenerFormatoPdf($comprobante)
    {
        if ($comprobante->documentable_type == 'App\Models\Venta') {
            return ($comprobante->documentable->detalle->contains('documentable_type', 'App\Models\PasajeBulto'))
                    ? 'TICKET'
                    : 'A5';
        }

        return 'A5';
    }
}
