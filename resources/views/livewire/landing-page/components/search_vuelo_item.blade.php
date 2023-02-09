<div class="p-8 card">

    <div class="grid grid-cols-3 gap-4">
        <div class="col-span-1">
            <div class="mb-5">
                <strong>
                    {{$vuelo['origen']->distrito}}
                </strong>
                <p class="text-sm text-gray-400">
                    {{$vuelo['origen']->descripcion}}
                </p>
            </div>
            <div>
                <strong>{{ optional($vuelo->fecha_hora_vuelo_programado)->format('g:ia') }}</strong>
                <span class="text-gray-400">
                    {{-- {{$nro_escalas}} --}}
                </span>
            </div>
        </div>
        <div class="col-span-1">
            <div class="mb-5">
                <strong>
                    {{$vuelo['destino']->distrito}}
                </strong>
                <p class="text-sm text-gray-400">
                    {{$vuelo['destino']->descripcion}}
                </p>
            </div>
            <div>
                <strong>{{ optional($vuelo->fecha_hora_vuelo_programado)->format('g:ia') }}</strong>
                <span class="font-bold text-gray-400">
                    {{-- {{$tiempo_min}} min --}}
                </span>
            </div>
        </div>
        <div class="col-span-1">
            <p class="text-gray-400">
                Equipaje
            </p>
        </div>
    </div>
</div>
