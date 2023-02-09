<div class="w-full ">
    <div class="w-full dropdown" >
        <div tabindex="0" class="w-full">
            <label class="block mb-2 text-sm font-bold text-gray-700" for="username">
                Buscar vuelo
            </label>
            <div class="flex">
                <input wire:model.debounce.600ms="search_vuelo"
                    class="flex-1 w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    type="text"
                    placeholder="Escriba el código ..." >
                <button wire:click="searchVuelo" class="btn btn-primary">
                    <i class="la la-search"></i>
                </button>
            </div>
        </div>
    </div>

    @if ($vuelo_founded)
        <div class="flex my-4">
            <div class="flex-1">
                <span class="font-bold text-gray-500">
                    {{optional($vuelo_founded->origen)->codigo_default}} ->
                    {{optional($vuelo_founded->destino)->codigo_default}}
                </span>
                <p>
                    De
                    <span class="text-primary">{{optional(optional($vuelo_founded->origen)->ubigeo)->distrito}}</span>
                    a
                    <span class="text-primary">{{optional(optional($vuelo_founded->destino)->ubigeo)->distrito}}</span>
                </p>
                <div class="text-gray-400">
                    {{optional($vuelo_founded->fecha_despegue_programado)->format('Y-m-d')}}
                    (
                     De {{optional($vuelo_founded->fecha_hora_vuelo_programado)->format('g:i:a')}}
                     a {{optional($vuelo_founded->fecha_hora_aterrizaje_programado)->format('g:i:a')}}
                    )
                </div>
            </div>
            <button class="btn btn-primary btn-outline" wire:click="setVuelo">
                <i class="la la-check"></i>
            </button>
        </div>

        @if ($vuelo_founded->vuelo_siguiente)
            <strong class="text-red-500">¡Espera!</strong> Este vuelo también va directo a:
            <div class="flex my-4">
                <div class="flex-1">
                    <span class="font-bold text-gray-500">
                        {{optional($vuelo_founded->origen)->codigo_default}} ->
                        {{optional($vuelo_founded->vuelo_siguiente->destino)->codigo_default}}
                    </span>
                    <p>
                        De
                        <span class="text-primary">{{optional(optional($vuelo_founded->vuelo_siguiente->origen)->ubigeo)->distrito}}</span>
                        a
                        <span class="text-primary">{{optional(optional($vuelo_founded->vuelo_siguiente->destino)->ubigeo)->distrito}}</span>
                    </p>
                    <div class="text-gray-400">
                        {{optional($vuelo_founded->vuelo_siguiente->fecha_hora_vuelo_programado)->format('Y-m-d')}}
                        (
                        De {{optional($vuelo_founded->fecha_hora_vuelo_programado)->format('g:i:a')}}
                        a {{optional($vuelo_founded->vuelo_siguiente->fecha_hora_aterrizaje_programado)->format('g:i:a')}}
                        )
                    </div>
                </div>
                <button class="btn btn-primary btn-outline" wire:click="setVuelo('with_next')">
                    <i class="la la-check"></i>
                </button>
            </div>
        @endif
    @endif

</div>

