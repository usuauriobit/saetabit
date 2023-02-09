<div>
    @if (!$isSimple)
        <strong>{{$ruta['tipo_vuelo']['descripcion']}}</strong>
    @endif
    <div class="flex items-stretch justify-between">
        <div class="flex-1 w-48 p-4 bg-gray-50">
            @if (!$isSimple)
                <i class="text-2xl font-bold la la-plane-departure"></i>
                <div class="text-2xl font-bold text-primary">
                    {{$ruta['tramo']['origen']['codigo_default']}}
                </div>
            @endif
            <p class="text-xs font-bold text-gray-500">
                {{optional(optional($ruta['tramo']['origen'])['ubigeo'])[$isSimple ? 'distrito' : 'descripcion']}}
            </p>
        </div>
        @isset($ruta['tramo']['escala'])
            <div class="flex-1 w-48 p-4 mx-2 text-center bg-gray-50">
                @if (!$isSimple)
                    <i class="las la-plane"></i>
                    <div class="text-2xl font-bold text-primary">
                        {{$ruta['tramo']['escala']['codigo_default']}}
                    </div>
                @endif
                <p class="text-xs font-bold text-gray-500">
                    {{optional(optional($ruta['tramo']['escala'])['ubigeo'])[$isSimple ? 'distrito' : 'descripcion']}}
                </p>
            </div>
        @else
            <div class="self-center flex-shrink px-4 text-center py-auto">
                <div class="mt-10 text-center">
                    <i class="mx-auto las la-ellipsis-h"></i>
                    <i class="mx-auto las la-fighter-jet"></i>
                    <i class="mx-auto las la-ellipsis-h"></i>
                </div>
            </div>
        @endisset
        <div class="flex-1 w-48 p-4 text-right bg-gray-50">
            @if (!$isSimple)
                <i class="text-2xl font-bold la la-plane-arrival"></i>
                <div class="text-2xl font-bold text-primary">
                    {{$ruta['tramo']['destino']['codigo_default']}}
                </div>
            @endif
            {{-- <p class="font-semibold text-2xs">
                {{optional($ruta['tramo']['destino'])['descripcion']}}
            </p> --}}
            <p class="text-xs font-bold text-gray-500">
                {{optional(optional($ruta['tramo']['destino'])['ubigeo'])[$isSimple ? 'distrito' : 'descripcion']}}
            </p>
        </div>
    </div>

    {{-- {{$slot}} --}}
</div>
