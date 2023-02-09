<div class="card-white">
    <div class="card-body">
        <div class="mb-4 font-bold text-center">
            {{optional($vuelo->fecha_hora_vuelo_programado)->format('d/m/Y')}}
        </div>
        <div class="text-center">
            <img class="mx-auto" style="width: 154pt" src="{{ asset('img/repo/flight-route.svg') }}" alt="">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <div class="text-gray-400">
                    Origen
                </div>
                <div class="text-lg text-gray-600">
                    <strong>
                        {{optional($vuelo->origen)->codigo_default }}
                    </strong>
                </div>
                <div class="text-md text-primary">
                    <strong>
                        {{optional(optional($vuelo->origen)->ubigeo)->distrito }}
                    </strong>
                </div>
                <div class="font-bold text-md">
                    <strong>
                        {{optional($vuelo->fecha_hora_vuelo_programado)->format('g:ia')}}
                    </strong>
                </div>
            </div>
            <div class="text-right">
                <div class="text-gray-400">
                    Destino
                </div>
                <div class="text-lg text-gray-600">
                    <strong>
                        {{optional($vuelo->destino)->codigo_default }}
                    </strong>
                </div>
                <div class="text-md text-primary">
                    <strong>
                        {{optional(optional($vuelo->destino)->ubigeo)->distrito }}
                    </strong>
                </div>
                <div class="font-bold text-md">
                    <strong>
                        {{optional($vuelo->fecha_hora_aterrizaje_programado)->format('g:i a')}}
                    </strong>
                </div>
            </div>
        </div>
    </div>
</div>
