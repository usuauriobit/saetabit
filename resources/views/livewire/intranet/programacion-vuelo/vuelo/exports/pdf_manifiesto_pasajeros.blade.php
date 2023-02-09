<link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
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
                        Manifiesto de pasajeros
                    </td>
                </tr>
                <tr class="bg-gray ">
                    <td class="py-md">
                        N° <strong>{{ $vuelo->id }}</strong> <br>
                        Fecha: <strong>
                        @if ($vuelo->hora_despegue)
                            {{ $vuelo->hora_despegue->format('d-m-Y') }}
                        @else
                            {{ optional($vuelo->fecha_hora_vuelo_programado)->format('d-m-Y') }}
                        @endif
                        </strong>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<table  class="table">
    <tr>
        <th>Nro</th>
        <th>Documento</th>
        <th>Pasajero</th>
        <th>Destino</th>
        <th>Pax</th>
        <th>Peso Pax</th>
        <th>Bultos</th>
        <th>Peso Bultos</th>
    </tr>
    @foreach ($vuelo->pasajes_con_checkin as $pasaje)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ optional($pasaje->pasajero)->nro_doc }}</td>
            <td>{{ $pasaje->nombre_short }}</td>
            <td>{{ optional(optional(optional($pasaje->vuelo_destino)->destino)->ubigeo)->distrito }}</td>
            <td>{{ optional($pasaje->tipo_pasaje)->abreviatura }}</td>
            <td>@nro($pasaje->peso_persona) kg</td>
            <td>{{ $pasaje->nro_bultos }}</td>
            <td>@nro($pasaje->peso_bultos) Kg</td>
        </tr>
    @endforeach

    <tr>
        <th colspan="5">TOTAL</th>
        <td>@nro(optional($vuelo->pasajes_con_checkin)->sum('peso_persona') ) Kg</td>
        <td>{{ optional($vuelo->pasajes_con_checkin)->sum('nro_bultos') }}</td>
        <td>@nro(optional($vuelo->pasajes_con_checkin)->sum('peso_bultos')) Kg</td>
    </tr>
    <tr>
        <td colspan="8"></td>
    </tr>
    <tr>
        <th colspan="5">TOTAL EN PESO</th>
        <td colspan="3">@nro(optional($vuelo->pasajes_con_checkin)->sum('peso_persona') + optional($vuelo->pasajes_con_checkin)->sum('peso_bultos')) Kg</td>
    </tr>

</table>

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
                Firma de piloto
            </td>
        </tr>
    </table>
</footer>
