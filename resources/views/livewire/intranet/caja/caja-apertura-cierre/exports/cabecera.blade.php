<table width="100%">
    <tr>
        <td width="20%">
            <img src="{{ asset('img/logo-color.png') }}" alt="" width="150px">
        </td>
        <td width="50%" style="text-align: center;">
            <h3>Servicios Aéreos Tarapoto EIRL</h3>
            <p style="font-size: 10px;">
                {{ 'RUC 2013232323 ' . $apertura_cierre->caja->oficina->direccion . ' - Teléfono: ' . $apertura_cierre->caja->oficina->telefonos_string }} <br>
            </p>
            <p style="font-size: 10px;">
                www.saetaperu-com - email: ventas@saetaperu.com
            </p>
        </td>
        <td width="30%">
            <p>Cajero {{ $apertura_cierre->user_created->email }}</p>
            <p>Cierre {{ $apertura_cierre->codigo }}</p>
            <p>Impresión {{ date('d-m-Y') }}</p>
        </td>
    </tr>
</table>
