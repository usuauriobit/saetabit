<td class="w-60">
    <table class="w-100">
        <tr>
            <td>
                <div class="mb-3 mt-3" style="text-align: center">
                    <img src="{{asset('img/logo-color.png')}}" alt="">
                    <br>
                    <strong class="text-lg">Tarjeta de embargue - Boarding pass</strong>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <table class="w-100">
                    <tr>
                        <td>
                            <span>{{optional(optional($pasaje->origen)->ubigeo)->distrito}}</span>
                            <div style="margin-top: -12pt">
                                <strong style="font-size: 22pt; font-weight: bold">
                                    {{optional($pasaje->origen)->codigo_default}}
                                </strong>
                            </div>
                        </td>
                        <td style="text-align: center">
                            <img src="{{ asset('img/repo/ion_airplane.svg') }}" alt="">
                        </td>
                        <td style="text-align: right">
                            <span>{{optional(optional($pasaje->destino)->ubigeo)->distrito}}</span>
                            <div style="margin-top: -12pt">
                                <strong style="font-size: 22pt; font-weight: bold">
                                    {{optional($pasaje->destino)->codigo_default}}
                                </strong>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table class="w-100">
                    <tr>
                        <td class="w-30">
                            <span class="primary-color">Nº DOC</span> <br>
                            {{$pasaje->pasajero->nro_doc}}
                        </td>
                        <td class="w-70">
                            <span class="primary-color">NOMBRE</span> <br>
                            {{$pasaje->pasajero->nombre_short}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table class="w-100">
                    <tr>
                        <td class="w-30">
                            <span class="primary-color">TIPO PAX</span> <br>
                            {{$pasaje->tipo_pasaje->abreviatura}}
                        </td>
                        <td class="w-70">
                            <span class="primary-color">FECHA - HORA VUELO</span> <br>
                            {{optional(optional($pasaje->vuelo_origen)->fecha_hora_vuelo_programado)->format('d-m-Y g:i a')}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div class="mt-3 text-md">
                    <strong style="color: red">IMPORTANTE: </strong>
                    Presentarse a la sala de embargue:
                    <strong class="text-lg">{{ $pasaje->horario_embargue->format('g:i a') }}</strong>
                </div>
            </td>
        </tr>
    </table>
    @include('livewire.intranet.comercial.pasaje.exports.boarding-pass.separator')

    <table class="w-100">
        <tr>
            <td colspan="2">
                @if ($tarifa_bulto)
                    <table>
                        <tr>
                            <td>
                                <img src="{{ asset('img/repo/baggage-icon.svg') }}" alt="">
                            </td>
                            <td>
                                <strong class="text-lg">{{$tarifa_bulto->peso_max}} Kg</strong> <br>
                                <strong>
                                    Equipaje permitido
                                </strong>
                                <div class="text-sm">
                                    (S/ {{$tarifa_bulto->monto_kg_excedido}} por kg excedido)
                                </div>
                            </td>
                        </tr>
                    </table>
                @endif
            </td>
        </tr>
        <tr>
            <td>
                <div class="text-sm mt-2">
                    <strong>Contáctanos</strong>
                    <br>
                    <span>
                        972 657 957 | 948 338 905 | 942 977 888
                        <br>
                        www.saetaairlines.com
                    </span>
                </div>
            </td>
            <td class="mt-2">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::size(100)->generate('http://www.saetaperu.com')) !!} ">
            </td>
        </tr>
    </table>
</td>
