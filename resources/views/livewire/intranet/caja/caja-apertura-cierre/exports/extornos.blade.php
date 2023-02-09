<h2 style="text-align: center;">EXTORNOS</h2>

<table style="width: 100%; margin-top: 20px;">
    <tr>
        <td style="font-weight: bold;">NumServ</td>
        <td style="font-weight: bold;">Fecha</td>
        <td style="font-weight: bold;">Cliente</td>
        <td style="font-weight: bold;">Motivo E.</td>
        <td style="font-weight: bold;">Importe</td>
    </tr>
    @foreach ($service::movimientosExtornados($apertura_cierre->id) as $movimiento)
        <tr>
            <td>{{ $movimiento->codigo }}</td>
            <td>{{ $movimiento->fecha->format('d-m-Y') }}</td>
            <td>{{ $movimiento->documentable->descripcion_cliente }}</td>
            <td>{{ $movimiento->motivo_extorno }}</td>
            <td style="text-align: right;">{{ number_format($movimiento->total, 2, '.', ',') }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="4" style="font-weight: bold; text-align: right;">Total</td>
        <td style="font-weight: bold; text-align: right;">
            {{ 'S/. ' . number_format($service::totalmovimientosExtornados($apertura_cierre->id), 2, '.', ',') }}
        </td>
    </tr>
</table>
