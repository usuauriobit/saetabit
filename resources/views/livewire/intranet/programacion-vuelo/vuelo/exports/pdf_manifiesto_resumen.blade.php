<link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
<table  style="width: 100%;">
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
                    <th>Ruta</th>
                    <td>{{Str::of($vuelo->ruta_descripcion)->upper()}}</td>
                </tr>
                <tr>
                    <th>Fecha de vuelo</th>
                    <td>{{ optional($vuelo->fecha_hora_vuelo_programado)->format('Y-m-d') }}</td>
                    <th>Hora prog.</th>
                    <td>{{ optional($vuelo->fecha_hora_vuelo_programado)->format('g:i a') }}</td>
                </tr>
            </table>
        </td>
        <td width="20%">
            <table width="100%" style="text-align: center;">
                <tr style="border: 1px solid blue;">
                    <td class="text-white bg-primary pa-md">
                        Reporte de vuelo
                    </td>
                </tr>
                <tr class="bg-gray ">
                    <td class="py-md">
                        N° <strong>{{ $vuelo->id }}</strong> <br>
                        Fecha: <strong>{{ $vuelo->hora_despegue->format('d-m-Y') }}</strong>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="width: 100%;">
    <tr>
        <td style="width: 60%">
            <table class="table">
                <tr>
                    <th style="width: 70px">Origen</th>
                    <td>{{ $vuelo->origen->descripcion }}</td>
                </tr>
                <tr>
                    <th style="width: 70px">Destino</th>
                    <td>{{ $vuelo->origen->descripcion }}</td>
                </tr>
                <tr>
                    <th>Piloto</th>
                    <td>{{ Str::of(optional($vuelo->piloto)->nombre_parcial)->upper() }}</td>
                </tr>
                <tr>
                    <th style="width: 70px">Copiloto</th>
                    <td>{{ Str::of(optional($vuelo->copiloto)->nombre_parcial ?? '')->upper() }}</td>
                </tr>
            </table>
        </td>
        <td style="width: 40%">
            <table class="table">
                <tr>
                    <th style="width: 100px">Avión</th>
                    <td>
                        <strong>{{ optional($vuelo->avion)->matricula }}</strong>
                        <br>
                        {{ optional($vuelo->avion)->descripcion}}
                    </td>
                </tr>
                <tr>
                    <th style="width: 100px">Despegue</th>
                    <td>{{ optional($vuelo->hora_despegue)->format('g:i a') }}</td>
                </tr>
                <tr>
                    <th style="width: 100px">Aterrizaje</th>
                    <td>{{ optional($vuelo->hora_aterrizaje)->format('g:i a') }}</td>
                </tr>
                <tr>
                    <th style="width: 100px">Tiempo de vuelo</th>
                    <td>{{ $vuelo->tiempo_vuelo }}</td>
                </tr>
            </table>

        </td>
    </tr>
</table>
<table>
    <tr>
        <td></td>
    </tr>
</table>
<table class="table">
    <tr>
        <th>CONCEPTO</th>
        <th>CANT</th>
        <th>CONTADO</th>
        <th>CREDITO</th>
        <th>TOTAL</th>
    </tr>
    <tr>
        <th>PASAJES AEREOS</th>
        <td class="text-center">{{ $vuelo->pasajes_aereos_cantidad }}</td>
        <td class="text-right">@soles($vuelo->pasajes_aereos_contado)</td>
        <td class="text-right">@soles($vuelo->pasajes_aereos_credito)</td>
        <td class="text-right">@soles($vuelo->pasajes_aereos_total)</td>
    </tr>
    <tr>
        <th>CARGA Y CORREO</th>
        <td class="text-center">{{ $vuelo->carga_correo_cantidad }}</td>
        <td class="text-right">@soles($vuelo->carga_correo_contado)</td>
        <td class="text-right">@soles($vuelo->carga_correo_credito)</td>
        <td class="text-right">@soles($vuelo->carga_correo_total)</td>
    </tr>
    <tr>
        <th>EXCESO DE EQUIPAJE</th>
        <td class="text-center">{{ $vuelo->exceso_equipaje_cantidad }}</td>
        <td class="text-right">@soles($vuelo->exceso_equipaje_contado)</td>
        <td class="text-right">@soles($vuelo->exceso_equipaje_credito)</td>
        <td class="text-right">@soles($vuelo->exceso_equipaje_total)</td>
    </tr>
    <tr>
        <th>CAMBIO TITULAR/FECHA/RUTA</th>
        <td class="text-center">{{ $vuelo->cambio_titular_fecha_cantidad }}</td>
        <td class="text-right">@soles($vuelo->cambio_titular_fecha_contado)</td>
        <td class="text-right">@soles($vuelo->cambio_titular_fecha_credito)</td>
        <td class="text-right">@soles($vuelo->cambio_titular_fecha_total)</td>
    </tr>
    <tr>
        <th colspan="2">TOTALES</th>
        <td class="text-right"><strong>@soles($vuelo->total_contado)</strong></td>
        <td class="text-right"><strong>@soles($vuelo->total_credito)</strong></td>
        <td class="text-right"><strong>@soles($vuelo->total_total)</strong></td>
    </tr>
</table>



<table width="100%" style="margin-top: 100px">
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
</table>
