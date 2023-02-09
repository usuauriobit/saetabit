
{{-- <link rel="stylesheet" href="{{ asset('css/pdf.css') }}"> --}}

<style>
    body {
        font-size: 12px;
    }
    footer {
        position: fixed;
        bottom: -60px;
        left: 0px;
        right: 0px;
        height: 50px;
    }
    table {
        border-collapse: collapse;
    }
</style>

<table width="100%">
    <tr>
        <td width="20%">
            <img src="{{ asset('img/logo-color.png') }}" alt="" width="150px">
        </td>
        <td width="50%">
            <p style="font-size: 10px;">
                @foreach ($oficinas as $oficina)
                    {{ $oficina->descripcion . ': ' . $oficina->direccion . ' - Teléfono: ' . $oficina->telefonos_string }} <br>
                @endforeach
            </p>
        </td>
        <td width="30%">
            <table width="100%" style="text-align: center;">
                <tr style="border: 1px solid blue;">
                    <td style="border:1px solid blue; font-weight: bold; background-color: blue; color: white;">
                        Guía de Despacho
                    </td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid blue; border-bottom: 1px solid blue; border-right: 1px solid blue; padding-left:7px">
                        N° <strong>{{ $guia_despacho->codigo }}</strong>
                        &nbsp;&nbsp; {!! DNS1D::getBarcodeHTML($guia_despacho->codigo, 'CODABAR') !!}
                        <strong>{{ $guia_despacho->fecha->format('d-m-Y') }}</strong>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td align="right">RUTA</td>
        <td style="font-weight: bold;">
            {{ Str::of($guia_despacho->ruta)->upper() }}
        </td>
    </tr>
    <tr>
        <td align="right">REMITENTE</td>
        <td style="font-weight: bold;">
            {{ Str::of('DNI  ' . $guia_despacho->remitente->nro_doc . '  ' . $guia_despacho->remitente->nombre_completo)->upper() }}
        </td>
    </tr>
    <tr>
        <td align="right">CONSIGNATARIO</td>
        <td style="font-weight: bold;">
            {{ Str::of($guia_despacho->consignatario->nombre_completo)->upper() }}
        </td>
    </tr>
</table>

<table width="100%" style="margin-top:20px;">
    <tr>
        <th style="border-top:1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;">
            ITEM
        </th>
        <th style="border-top:1px solid black; border-bottom: 1px solid black;">
            DESCRIPCION
        </th>
        <th style="border-top:1px solid black; border-bottom: 1px solid black;">
            PESO
        </th>
        <th style="border-top:1px solid black; border-right:1px solid black; border-bottom: 1px solid black;">
            IMPORTE
        </th>
    </tr>
    @foreach ($guia_despacho->detalles as $detalle)
        <tr>
            <td align="center" style="border-bottom: 1px solid black;">
                {{ Str::padLeft($loop->iteration, 2, '0') }}
            </td>
            <td style="border-bottom: 1px solid black;">
                {{ $detalle->descripcion }}
            </td>
            <td align="right" style="border-bottom: 1px solid black;">
                {{ number_format($detalle->peso, 2, '.', ',') }}
            </td>
            <td align="right" style="border-bottom: 1px solid black;">
                {{ number_format($detalle->importe, 2, '.', ',') }}
            </td>
        </tr>
    @endforeach
    <tr>
        <th align="right" colspan="3">SUBTOTAL</th>
        <th align="right">{{ number_format($guia_despacho->sub_total, 2, '.', ',') }}</th>
    </tr>
    <tr>
        <th align="right" colspan="3">IGV</th>
        <th align="right">{{ number_format($guia_despacho->total_igv, 2, '.', ',') }}</th>
    </tr>
    <tr>
        <th align="right" colspan="3">TOTAL</th>
        <th align="right">{{ number_format($guia_despacho->total, 2, '.', ',') }}</th>
    </tr>
</table>

<table width="100%" style="margin-top:20px;">
    <tr>
        <td style="border: 1px solid black; text-align: center;">
            El remitente declara bajo juramento que no transporta mercacias peligrosas, drogas y/o estupefacientes, cargas y sustancias prohibidas
        </td>
    </tr>
</table>

<footer>
    {{ 'Impresión: ' . date('d-m-Y') . ' Usuario: ' . $guia_despacho->user_created->name }}
</footer>


