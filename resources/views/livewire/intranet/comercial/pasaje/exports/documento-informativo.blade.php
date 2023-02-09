<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Documento informativo</title>
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">

    <style>
        @font-face {
            font-family: "Jura";
            src: url("{{ storage_path('fonts/Jura/Jura-Regular.ttf') }}") format("truetype");
            font-weight: normal;
        }
        @font-face {
            font-family: "Jura";
            src: url("{{ storage_path('fonts/Jura/Jura-Bold.ttf') }}") format("truetype");
            font-weight: bold;
        }
        @page { margin: 15px; }
        body{
            font-family: "Jura", cursive;
            font-size: 8pt;
            margin: 2px;
        }
    </style>
</head>
<body>
    @php
        $oficinas = \App\Models\Oficina::get();
    @endphp
    <table class="w-100">
        <tr>
            <td style="width: 50px">
                <img src="{{ asset('img/logo-color.png') }}" alt="">
            </td>
            <td style="font-size: 6pt;  color: #383838; padding-left: 10px">
                @foreach ($oficinas as $oficina)
                    <strong>{{ optional($oficina->ubigeo)->distrito }}:</strong>
                    <br> {{$oficina->direccion}} -Teléfono: {{optional($oficina->telefonos[0] ?? null)->nro_telefonico}}
                    <br>
                @endforeach
            </td>
            <td width="25%">
                <table width="100%" style="text-align: center;">
                    <tr style="border: 1px solid blue;">
                        <td class="text-white bg-primary pa-md">
                            Documento informativo
                        </td>
                    </tr>
                    <tr class="bg-gray ">
                        <td class="py-md">
                            N° <strong>{{ $pasaje->codigo }}</strong> <br>
                            {{ optional(optional(Auth::user()->oficina)->ubigeo)->distrito }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table  width="100%">
        <tr>
            <td>
                <table>
                    <tr>
                        <td style="width: 12pt">
                            <img style="width: 16pt" src="{{ asset('img/asset/flight-pdf/plane-departure.png') }}" alt="">
                        </td>
                        <td>
                            <div style="margin-bottom: 3px; font-size: 7pt">
                                <strong style="color: #8c8c8c">Origen</strong> <br>
                                <strong style="color: #314ed1; font-size: 10pt">{{optional(optional($pasaje->origen)->ubigeo)->descripcion}}</strong> <br>
                                <span style="color: #3c3c3c">{{optional($pasaje->origen)->descripcion}}</span>
                            </div>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="width: 12pt">
                            <img style="width: 15pt" src="{{ asset('img/asset/flight-pdf/plane-arrival.png') }}" alt="">
                        </td>
                        <td>
                            <div style="margin-bottom: 3px; font-size: 7pt">
                                <strong style="color: #8c8c8c">Destino</strong> <br>
                                <strong style="color: #314ed1; font-size: 10pt">{{optional(optional($pasaje->destino)->ubigeo)->descripcion}}</strong> <br>
                                <span style="color: #3c3c3c">{{optional($pasaje->destino)->descripcion}}</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="padding-left: 16pt">
                <table>
                    <tr>
                        <td style="width: 12pt">
                            <img style="width: 15pt" src="{{ asset('img/asset/flight-pdf/stream.png') }}" alt="">
                        </td>
                        <td>
                            <div style="margin-bottom: 3px; font-size: 7pt">
                                <strong style="color: #8c8c8c">Tipo PAX</strong> <br>
                                <span style="color: #3c3c3c">{{optional($pasaje->tipo_pasaje)->descripcion}}</span>
                            </div>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="width: 12pt">
                            <img style="width: 13pt" src="{{ asset('img/asset/flight-pdf/user.png') }}" alt="">
                        </td>
                        <td>
                            <div style="margin-bottom: 3px; font-size: 7pt">
                                <strong style="color: #8c8c8c">Pasajero</strong> <br>
                                <span style="color: #3c3c3c">{{$pasaje->nro_doc}} - {{$pasaje->nombre_short}}</span>
                            </div>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="width: 12pt">
                            <img style="width: 13pt" src="{{ asset('img/asset/flight-pdf/calendar.png') }}" alt="">
                        </td>
                        <td>
                            <div style="margin-bottom: 3px; font-size: 7pt">
                                <strong style="color: #8c8c8c">Fecha/Hora Vuelo</strong> <br>
                                @if ($pasaje->is_abierto)
                                    <span style="color: #3c3c3c">Sin asignar</span>
                                @else
                                    <span style="color: #3c3c3c">{{optional(optional($pasaje->vuelo_origen)->fecha_hora_vuelo_programado)->format('Y-m-d g:i a')}}</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td  width="20%" style="text-align: end">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::size(100)->generate('http://www.saetaperu.com')) !!} ">
            </td>
        </tr>
    </table>
    <table class="w-100">
        @if ($pasaje->is_abierto)
            <strong style="color: rgb(218, 83, 83)">ESTE PASAJE NO TIENE VUELO ASIGNADO: </strong>
        @else
            <div class="mt-3 text-md" style="margin-left: 10px; font-size: 8pt">
                <strong style="color: rgb(218, 83, 83)">IMPORTANTE: </strong>
                Presentarse a la sala de embargue:
                <strong class="text-lg">{{ optional($pasaje->horario_embargue)->format('g:i a') ?? '-' }}</strong>
            </div>
        @endif
    </table>
    <table class="w-100">
        <tr>
            <td>
                <div style="font-size: 8pt; border-radius: 10px; border: 1px solid #ff6464; color: #ff6464; padding:6px; text-align:center ">
                    ESTE DOCUMENTO NO REPRESENTA LA TARJETA DE EMBARQUE
                </div>
            </td>
        </tr>
    </table>
    @include('livewire.intranet.comercial.pasaje.exports.documento-informativo.section-consideraciones')
    <table  width="100%" style="color:#787878; font-size: 5pt">
        <tr>
            <td>
                <strong>Impresión:</strong> {{ date('Y-m-d H:i a') }} &nbsp;&nbsp;&nbsp;
                <strong>Usuario: </strong> {{ Auth::user()->user_name }}
            </td>
            <td style="text-align: right">
                <strong>Fecha de creación: </strong> {{ $pasaje->created_at->format('Y-m-d H:i a') }}
            </td>
        </tr>
    </table>
</body>
</html>
