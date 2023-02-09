<h3 style="text-align: center;">INGRESOS POR TIPO DE PAGO</h3>

@foreach ($tipo_pagos as $tipo_pago)
    @if ($service::movimientosTipoPago($tipo_pago->id, $apertura_cierre->id)->count() > 0)
        <h3 style="text-align: left;">{{ Str::of($tipo_pago->descripcion)->upper() }}</h3>
        <table style="width: 100%; margin-top: 20px;">
            <tr>
                <td style="font-weight: bold;">Doc</td>
                <td style="font-weight: bold;">Serie</td>
                <td style="font-weight: bold;">Num</td>
                <td style="font-weight: bold;">Fecha</td>
                <td style="font-weight: bold;">NumServ</td>
                <td style="font-weight: bold;">Glosa</td>
                <td style="font-weight: bold;">Cliente</td>
                <td style="font-weight: bold;">Ruta</td>
                <td style="font-weight: bold;">Importe</td>
            </tr>
            @foreach ($service::movimientosTipoPago($tipo_pago->id, $apertura_cierre->id) as $movimiento)
                <tr>
                    <td>{{ $movimiento->tipo_comprobante }}</td>
                    <td>{{ $movimiento->serie }}</td>
                    <td>{{ $movimiento->correlativo }}</td>
                    <td>{{ $movimiento->fecha->format('d-m-Y') }}</td>
                    <td>{{ $movimiento->codigo }}</td>
                    <td>{{ $movimiento->tipo_operacion }}</td>
                    <td>{{ $movimiento->documentable->descripcion_cliente }}</td>
                    <td>{{ optional($movimiento ?? null)->ruta ?? null }}</td>
                    <td style="text-align: right;">{{ number_format($movimiento->total, 2, '.', ',') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="8" style="font-weight: bold; text-align: right;">Total</td>
                <td style="font-weight: bold; text-align: right;">
                    {{ 'S/. ' . number_format($service::totalTipoPago($tipo_pago->id, $apertura_cierre->id), 2, '.', ',') }}
                </td>
            </tr>
        </table>
    @endif
@endforeach

<table style="width: 100%; margin-top: 20px;">
    <tr>
        <td style="font-weight: bold; text-align: center; font-size: 20px;">Ingreso Total</td>
        <td style="font-weight: bold; text-align: right; font-size: 20px;">
            {{ 'S/. ' . number_format($apertura_cierre->total_recaudado, 2, '.', ',') }}
        </td>
    </tr>
</table>
