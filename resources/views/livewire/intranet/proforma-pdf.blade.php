@php
    $fecha = \Carbon\Carbon::createFromFormat('Y-m-d', $form['fecha'])->translatedFormat('d \d\e F \d\e Y');
    $avion = App\Models\Avion::find($form['avion_id']);
    $origen = App\Models\Ubicacion::find($form['origen_id']);
    $destino = App\Models\Ubicacion::find($form['destino_id']);
    $oficina = Auth::user()->personal->oficina;
@endphp
<style>
    body {
        /* font-size: 12px; */
    }
    footer {
        position: fixed;
        bottom: -5px;
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
        <td width="50%">
            <img src="{{ asset('img/logo-color.png') }}" alt="" width="150px">
        </td>
        <td width="50%">
            <h4 align="right">{{ $oficina->descripcion . ', ' . $fecha }}</h4>
        </td>
    </tr>
</table>

<h4>Srs. <br> {{ $form['cliente'] }}</h4>
<p>De mi mayor consideración;</p>
<p>Mediante la presente nos es grato saludarle y a la vez hacer llegar nuestra mejor oferta
    en el Servicio en la ruta solicitada:
</p>
<table width="100%">
    <tr>
        <td width="50%" style="font-weight: bold; text-align: center; border: 1px solid black;">
            Descripción de la Nave
        </td>
        <td width="50%" style="font-weight: bold; text-align: center; border: 1px solid black;">
            {{ $origen->ubigeo->distrito . ' - ' . $destino->ubigeo->distrito }}
        </td>
    </tr>
    <tr>
        <td style="border: 1px solid black;">
            <p>
                {{-- JETSTREAM 3200 (capacidad 09 pasajeros) Esta aeronave alcanza una velocidad de crucero de 680 KM/H, es bimotor
                turbohélice, certificado para vuelos diurnos, nocturnos y por instrumentos, cuenta con cabina presurizada para
                confort de los pasajeros y 02 amplias bodegas de equipaje. --}}
                {{ $avion->descripcion }}
            </p>
        </td>
        <td style="border: 1px solid black; text-align: center; font-size: 28px; font-weight: bold;">
            {{ 'S/. ' . number_format($form['precio'], 2, '.', ',') }}
        </td>
    </tr>
</table>

@if (count($notas) > 0)
    <div style="font-size: 13px;">
        Nota:
        <ul>
            @foreach ($notas as $nota)
                <li>{{ $nota }}</li>
            @endforeach
            {{-- <li>Vuelo incluye el pago de los impuestos TUUA</li>
            <li>El vuelo incluye medico a bordo y ambulancia en lima</li>
            <li>Aeronave con capacidad para trasladar 01 paciente en camilla más familiar.</li> --}}
        </ul>
    </div>
@endif

<p>
    Somos una empresa certificada por la Dirección General de Aeronáutica Civil, con 21
    años de experiencia en las rutas de la selva.
</p>
<p>
    Sin otro particular quedo de usted.
</p>
<p style="text-align:center">
    Atentamente,
    <br>
    <br>
    <br>
    <br>
    <br>
    ---------------------------------- <br>
    Daniel Escalante Gómez <br>
    Gerente General
</p>

<footer>
    <hr>
    <div style="text-align: center; font-size: 12px;">
        <b>Servicios Aéreos Tarapoto E.I.R.L.</b>
        <br>
        {{ $oficina->direccion . ' - ' . $oficina->descripcion . ', Telf.: ' . $oficina->telefonos_string  }}
        <br>
        E-mail: saetaperu@yahoo.com
    </div>
</footer>


