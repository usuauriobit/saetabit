<td class="p-3"
style="
    border-radius: 16px;
    width: 40%;
    background: url('{{ asset('img/repo/background-pdf.png')}}');
    background-repeat: no-repeat;
    background-size: 100%;
">
    <table class="w-100" >
        <tr>
            <td>
                <strong>
                    {{optional(optional($pasaje->vuelo_origen)->fecha_hora_vuelo_programado)->format('d-m-Y')}}
                </strong>
            </td>
            <td class="text-r">
                <img style="width: 72pt" src="{{ asset('img/logo-color.png') }}" alt="">
            </td>
        </tr>
    </table>
    <table class="mt-2 w-100" >
        <tr>
            <td class=" text-c">
                <img style="width: 154pt" src="{{ asset('img/repo/flight-route.svg') }}" alt="">
            </td>
        </tr>
    </table>
    <table class="w-100" >
        <tr>
            <td class="w-50">
                <div>
                    Origen
                </div>
                <div class="text-lg primary-color">
                    <strong>
                        {{optional(optional(optional($pasaje->vuelo_origen)->origen)->ubigeo)->distrito }}
                    </strong>
                </div>
                <div class="text-lg">
                    <strong>
                        {{optional(optional($pasaje->vuelo_origen)->fecha_hora_vuelo_programado)->format('g:ia')}}
                    </strong>
                </div>
            </td>
            <td class="w-50 text-r">
                <div>
                    Destino
                </div>
                <div class="text-lg primary-color">
                    <strong>
                        {{optional(optional(optional($pasaje->vuelo_destino)->destino)->ubigeo)->distrito }}
                    </strong>
                </div>
                <div class="text-lg">
                    <strong>
                        {{optional(optional($pasaje->vuelo_destino)->fecha_hora_aterrizaje_programado)->format('g:i a')}}
                    </strong>
                </div>
            </td>
        </tr>
    </table>
    <table class="mt-2 w-100" >
        <tr class="text-c w-100">
            <td class="text-c w-100">
                <div class="text-lg">
                    <strong>{{$pasaje->tiempo_vuelo}} min</strong>
                </div>
                <div>
                    Tiempo de vuelo
                </div>
            </td>
        </tr>
    </table>
</td>
