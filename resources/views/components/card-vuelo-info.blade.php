
{{-- <div class="p-6 my-3 bg-gray-50 rounded-box">
    <div class="flex items-stretch justify-between">
        <div class="">
            <i class="text-2xl font-bold la la-plane-departure"></i>
            <div class="text-2xl font-bold text-primary">
                {{$vuelo['origen']['codigo_icao']}}
            </div>
            <p class="font-bold text-gray-500 text-md">
                {{optional(optional($vuelo['origen'])['ubigeo'])['distrito']}}
            </p>
            <p>
                {{$vuelo['fecha_vuelo_programado']}}
                <br>
                <strong>
                    {{$vuelo['hora_vuelo_programado']}}
                </strong>
            </p>
        </div>
        <div class="self-center py-auto">
            <div class="mt-10">
                <i class="las la-ellipsis-h"></i>
                <i class="las la-fighter-jet"></i>
                <i class="las la-ellipsis-h"></i>
            </div>
        </div>
        <div class="text-right">
            <i class="text-2xl font-bold la la-plane-arrival"></i>
            <div class="text-2xl font-bold text-primary">
                {{$vuelo['destino']['codigo_icao']}}
            </div>
            <p class="font-bold text-gray-500 text-md">
                {{optional(optional($vuelo['destino'])['ubigeo'])['distrito']}}
            </p>
            <p>
                {{$vuelo['fecha_aterrizaje_programado']}}
                <br>
                <strong>
                    {{$vuelo['hora_aterrizaje_programado']}}
                </strong>
            </p>
        </div>
    </div>
    <div class="mt-4 text-sm text-gray-500">
        ID: {{$vuelo['vuelo_codigo']}}
    </div>
</div> --}}

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
                <div>
                    Origen
                </div>
                <div class="text-lg text-primary">
                    <strong>
                        {{optional(optional($vuelo->origen)->ubigeo)->distrito }}
                    </strong>
                </div>
                <div class="text-lg">
                    <strong>
                        {{optional($vuelo->fecha_hora_vuelo_programado)->format('g:ia')}}
                    </strong>
                </div>
            </div>
            <div class="text-right">
                <div>
                    Destino
                </div>
                <div class="text-lg text-primary">
                    <strong>
                        {{optional(optional($vuelo->destino)->ubigeo)->distrito }}
                    </strong>
                </div>
                <div class="text-lg">
                    <strong>
                        {{optional($vuelo->fecha_hora_aterrizaje_programado)->format('g:i a')}}
                    </strong>
                </div>
            </div>
        </div>
    </div>
</div>
