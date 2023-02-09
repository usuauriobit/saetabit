<link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
<style>
    *{
        font-size: 8.5px
    }
</style>
<table style="width: 100%;">
    <tr >
        <td width="15%" class="text-center">
            <img src="{{ asset('img/logo-color.png') }}" alt="" width="100px">
            <br>
            {{ Auth::user()->personal->oficina->descripcion }}
        </td>
        <td width="65%" style="text-align: center;">
            <table class="table">
                <tr>
                    <th>Código</th>
                    <td>{{ $vuelo->codigo }}</td>
                    <th>Avión</th>
                    <td>
                        <strong>{{ optional($vuelo->avion)->matricula }}</strong>
                        <br>
                        {{ optional($vuelo->avion)->descripcion}}
                    </td>
                </tr>
                <tr>
                    <th>Piloto</th>
                    <td>{{ Str::of(optional($vuelo->piloto)->nombre_parcial)->upper() }}</td>
                    <th>Copiloto</th>
                    <td>{{ Str::of(optional($vuelo->copiloto)->nombre_parcial ?? '')->upper() }}</td>
                </tr>
                <tr>
                    <th>Ruta</th>
                    <td colspan="3">{{Str::of($vuelo->ruta_descripcion)->upper()}}</td>
                </tr>
            </table>
        </td>
        <td width="20%">
            <table width="100%" style="text-align: center;">
                <tr style="border: 1px solid blue;">
                    <td class="text-white bg-primary pa-md">
                        {{$is_manifiesto ? 'Manifiesto' : 'Preliminar'}} de carga
                    </td>
                </tr>
                <tr class="bg-gray ">
                    <td class="py-md">
                        N° <strong>{{ $is_manifiesto ? $vuelo->codigo_cargas : '-' }}</strong> <br>
                        Fecha: <strong>{{ optional($vuelo->hora_despegue)->format('d-m-Y') }}</strong>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table width="100%" class="table">
    <tr>
        <th>Origen</th>
        <th>Destino</th>
        <th>N° GD</th>
        <th>Fecha</th>
        <th>Remitente</th>
        <th>Consignatario</th>
        <th>Contenido</th>
        <th>Peso</th>
        <th>Total</th>
    </tr>
    @foreach ($vuelo->guias_despacho_vuelo as $row)
        <tr>
            <td style="text-align: center;">
                {{ $row->guia_despacho->origen->ubigeo->distrito }}
            </td>
            <td style="text-align: center;">
                {{ $row->guia_despacho->destino->ubigeo->distrito }}
            </td>
            <td style="text-align: center;">
                {{ $row->guia_despacho->codigo }}
            </td>
            <td style="text-align: center;">
                {{ optional(optional($row->guia_despacho)->fecha)->format('d-m-Y') }}
            </td>
            <td>{{ $row->guia_despacho->remitente->nombre_completo }}</td>
            <td>{{ $row->guia_despacho->consignatario->nombre_completo }}</td>
            <td>{{ $row->guia_despacho->contenido }}</td>
            <td style="text-align: right;">
                {{ number_format($row->guia_despacho->peso_total, 2, '.', ',') }}
            </td>
            <td style="text-align: right;">
                {{ number_format($row->guia_despacho->importe_total, 2, '.', ',') }}
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="7" style="text-align: right; border-top: 1px solid black; font-weight: bold;">
            {{ 'Peso Total  ' . number_format($vuelo->guias_despacho_vuelo->sum('peso_total'), 2, '.', ',') }}
        </td>
        <td style="text-align: right; border-top: 1px solid black;">
            Crédito
        </td>
        <td style="text-align: right; border-top: 1px solid black; font-weight: bold;">
            {{ number_format($vuelo->carga_correo_credito, 2, '.', ',') }}
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: right;">
            Contado
        </td>
        <td style="text-align: right; font-weight: bold;">
            {{ number_format($vuelo->carga_correo_contado, 2, '.', ',') }}
        </td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: right;">
            Total
        </td>
        <td style="text-align: right; font-weight: bold;">
            {{ number_format($vuelo->guias_despacho_vuelo->sum('importe_total'), 2, '.', ',') }}
        </td>
    </tr>
</table>
{{-- <br> <br> <br> --}}
{{-- <table width="100%">
    <tr>
        <td style="text-align: center;">
            ______________________ <br>
            Agente
        </td>
        <td style="text-align: center;">
            ______________________ <br>
            Piloto
        </td>
        <td style="text-align: center;">
            ______________________ <br>
            Administrador
        </td>
    </tr>
</table> --}}

<footer>
    <table width="100%">
        <tr>
            <td style="text-align: center;">
                Fecha Impresión <br> {{ date('d-m-Y') }}
            </td>
            <td style="text-align: center;">
                Usuario <br>  {{ Auth::user()->username  }}
            </td>
            <td style="text-align: center;">
                ______________________ <br>
                Entregué Conforme
            </td>
            <td style="text-align: center;">
                ______________________ <br>
                Recibí Conforme
            </td>
        </tr>
    </table>
</footer>
