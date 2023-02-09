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
                        Preliminar de pasajeros
                    </td>
                </tr>
                <tr class="bg-gray ">
                    <td class="py-md">
                        N° <strong>{{ $vuelo->codigo }}</strong> <br>
                        Fecha: <strong>{{ optional($vuelo->fecha_hora_vuelo_programado)->format('d-m-Y') }}</strong>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<table class="table"width="100%">
    <tr>
        <th>Nro </th>
        <th>Documento </th>
        <th>Pasajero </th>
        <th>Destino </th>
        <th>Pax </th>
        <th>Peso Pax </th>
    </tr>
    @foreach ($vuelo->pasajes_preliminares as $pasaje)
        <tr>
            <td class="text-center"> {{ $loop->iteration }} </td>
            <td class="text-center"> {{ optional($pasaje->pasajero)->nro_doc }} </td>
            <td> {{ $pasaje->nombre_short }} </td>
            <td class="text-center"> {{ Str::upper(optional(optional(optional($pasaje->vuelo_destino)->destino)->ubigeo)->distrito) }} </td>
            <td class="text-center"> {{ optional($pasaje->tipo_pasaje)->abreviatura }} </td>
            <td class="text-right"> @nro($pasaje->peso_persona) kg </td>
        </tr>
    @endforeach

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
        </tr>
    </table>
</footer>
