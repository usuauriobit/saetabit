<h3 style="text-align: center;">DETALLE DE ENTREGAS</h3>

<table style="width: 100%;">
    <tr>
        <td align="right">Cierre:</td>
        <td style="font-weight: bold;">
            {{ $apertura_cierre->codigo }}
        </td>
        <td align="right">Cajero:</td>
        <td style="font-weight: bold;">
            {{ $apertura_cierre->user_created->email }}
        </td>
        <td align="right">Fecha:</td>
        <td style="font-weight: bold;">
            {{ $apertura_cierre->fecha_apertura->format('d-m-Y') }}
        </td>
    </tr>
</table>
<table style="width: 100%; margin-top: 20px;">
    <tr>
        <td style="font-weight: bold;">Denominación</td>
        <td style="font-weight: bold;">Cantidad</td>
        <td style="font-weight: bold; text-align: center;">Total</td>
    </tr>
    @foreach ($apertura_cierre->billetes as $billete)
        <tr>
            <td>{{ $billete->denominacion->denominacion }}</td>
            <td>{{ $billete->cantidad }}</td>
            <td style="text-align: right;">{{ 'S/. ' . number_format($billete->total, 2, '.', ',') }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="2" style="font-weight: bold; text-align: center;">Total</td>
        <td style="font-weight: bold; text-align: right;">{{ 'S/. ' . number_format($apertura_cierre->total_billetes, 2, '.', ',') }}</td>
    </tr>
</table>

<table style="width: 100%; margin-top: 20px;">
    <tr>
        <td style="font-weight: bold;">Forma de Pago</td>
        <td style="font-weight: bold;">Total</td>
    </tr>
    @foreach ($tipo_pagos as $tipo_pago)
    <tr>
        <td>{{ $tipo_pago->descripcion }}</td>
        <td style="text-align: right;">
            {{ 'S/. ' . number_format($service::totalTipoPago($tipo_pago->id, $apertura_cierre->id), 2, '.', ',') }}
        </td>
    </tr>
    @endforeach
    <tr>
        <td style="font-weight: bold; text-align: center;">Total Recaudado</td>
        <td style="font-weight: bold; text-align: right;">
            {{ 'S/. ' . number_format($apertura_cierre->total_recaudado, 2, '.', ',') }}
        </td>
    </tr>
</table>
