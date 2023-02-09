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
    footer {
        position: fixed;
        bottom: -5px;
        left: 0px;
        right: 0px;
        height: 50px;
    }
</style>

<table width="100%">
    <tr>
        <td width="20%">
            <img src="{{ asset('img/logo-color.png') }}" alt="" width="150px">
        </td>
        <td width="60%" style="text-align: center;">
            <p>
                Código <strong>{{ $vuelo->id }}</strong> &nbsp;&nbsp;&nbsp;&nbsp;
                Fecha Vuelo <strong>{{ $vuelo->fecha_hora_vuelo_programado->format('d-m-Y') }}</strong> &nbsp;&nbsp;&nbsp;&nbsp;
                Hora Prog. <strong>{{ $vuelo->fecha_hora_vuelo_programado->format('h:m A') }}</strong>
            </p>
            <p>
                Ruta <strong>{{ Str::of($vuelo->ruta_descripcion)->upper() }}</strong>
            </p>
        </td>
        <td width="20%">
            <table width="100%" style="text-align: center;">
                <tr style="border: 1px solid blue;">
                    <td style="border:1px solid blue; font-weight: bold; background-color: blue; color: white;">
                        Reporte de Vuelo
                    </td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid blue; border-bottom: 1px solid blue; border-right: 1px solid blue; padding-left:7px">
                        N° <strong>{{ $vuelo->id }}</strong> <br>
                        <strong>{{ optional($vuelo->hora_despegue)->format('d-m-Y') }}</strong>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td style="text-align: center;">Origen</td>
        <td>{{ Str::of(optional($vuelo->origen)->descripcion)->upper() }}</td>
    </tr>
    <tr>
        <td style="text-align: center;">Destino</td>
        <td>{{ Str::of(optional($vuelo->destino)->descripcion)->upper() }}</td>
    </tr>
    <tr>
        <td style="text-align: center;">Piloto</td>
        <td>{{ Str::of(optional($vuelo->piloto)->nombre_completo)->upper() }}</td>
    </tr>
    <tr>
        <td style="text-align: center;">Copiloto</td>
        <td>{{ Str::of(optional($vuelo->copiloto)->nombre_completo)->upper() }}</td>
    </tr>
</table>
<br>
<table width="100%">
    <tr>
        <td style="border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;">
            Avión
        </td>
        <td style="border-top: 1px solid black; border-bottom: 1px solid black;">
           <Strong>{{ Str::of(optional($vuelo->avion)->matricula . ' ' . optional($vuelo->avion)->descripcion)->upper() }}</Strong>
        </td>
        <td style="border-top: 1px solid black; border-bottom: 1px solid black;">
            Despegue
        </td>
        <td style="border-top: 1px solid black; border-bottom: 1px solid black;">
           <strong>{{ optional($vuelo->hora_despegue)->format('h:m A') }}</strong>
        </td>
        <td style="border-top: 1px solid black; border-bottom: 1px solid black;">
            Aterrizaje
        </td>
        <td style="border-top: 1px solid black; border-bottom: 1px solid black;">
           <strong>{{ optional($vuelo->hora_aterrizaje)->format('h:m A') }}</strong>
        </td>
        <td style="border-top: 1px solid black; border-bottom: 1px solid black;">
            Minutos
        </td>
        <td style="border-top: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black;">
            <strong>{{ $vuelo->min_vuelo_real }}</strong>
        </td>
    </tr>
</table>
<br>
<table width="100%">
    <tr>
        <td style="font-weight: bold;">CONCEPTO</td>
        <td style="font-weight: bold; text-align: center;">CANT</td>
        <td style="font-weight: bold; text-align: center;">CONTADO</td>
        <td style="font-weight: bold; text-align: center;">CREDITO</td>
        <td style="font-weight: bold; text-align: center;">TOTAL</td>
    </tr>
    <tr>
        <td>PASAJES AEREOS</td>
        <td style="text-align: center;">{{ 0 }}</td>
        <td style="text-align: right;">{{ 0 }}</td>
        <td style="text-align: right;">{{ 0 }}</td>
        <td style="text-align: right;">{{ 0 }}</td>
    </tr>
    <tr>
        <td>CARGA Y CORREO</td>
        <td style="text-align: center;">{{ $vuelo->guias_despacho_vuelo->count() }}</td>
        <td style="text-align: right;">{{ number_format($vuelo->guias_despacho_vuelo->sum('importe_total'), 2, '.', ',') }}</td>
        <td style="text-align: right;">{{ 0 }}</td>
        <td style="text-align: right;">{{ number_format($vuelo->guias_despacho_vuelo->sum('importe_total'), 2, '.', ',') }}</td>
    </tr>
    <tr>
        <td>EXCESO DE EQUIPAJE</td>
        <td style="text-align: center;">{{ 0 }}</td>
        <td style="text-align: right;">{{ 0 }}</td>
        <td style="text-align: right;">{{ 0 }}</td>
        <td style="text-align: right;">{{ 0 }}</td>
    </tr>
    <tr>
        <td>CAMBIO TITULAR/FECHA</td>
        <td style="text-align: center;">{{ 0 }}</td>
        <td style="text-align: right;">{{ 0 }}</td>
        <td style="text-align: right;">{{ 0 }}</td>
        <td style="text-align: right;">{{ 0 }}</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right;">TOTAL</td>
        <td style="text-align: right;">{{ number_format($vuelo->guias_despacho_vuelo->sum('importe_total'), 2, '.', ',') }}</td>
        <td style="text-align: right;">{{ 0 }}</td>
        <td style="text-align: right;">{{ 0 }}</td>
    </tr>
</table>
<br> <br> <br>
<table width="100%">
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

<footer>
    <hr>
    <table width="100%">
        <tr>
            <td style="text-align: center;">
                Fecha Impresión {{ date('d-m-Y') }}
            </td>
            <td style="text-align: center;">
                Responsable Reporte: {{ Auth::user()->username  }}
            </td>
            <td style="text-align: center;">
                {{ Auth::user()->personal->oficina->descripcion }}
            </td>
        </tr>
    </table>
</footer>
