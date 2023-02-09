<div class="flex items-center">
    <div class="grow">
        <div class="p-3 bg-white rounded-t-lg rounded-box">
            <div class="mb-2">
                <span class="font-bold">Origen</span>
            </div>
            <x-item.ubicacion :ubicacion="$vueloOrigen->origen">
                <x-slot name="avatar">
                    <i class="las la-plane-departure"></i>
                </x-slot>
            </x-item.ubicacion>
            <x-master.item class="mt-5" label="Fecha de vuelo">
                <x-slot name="sublabel">
                    {{ optional($vueloOrigen->fecha_hora_vuelo_programado)->format('Y-m-d g:i a') }} (Programado)
                    <br>
                    @if ($vueloOrigen->hora_despegue)
                        {{ optional($vueloOrigen->hora_despegue)->format('Y-m-d g:i a') }} (Real)
                    @endif
                </x-slot>
                <x-slot name="avatar">
                    <i class="las la-calendar"></i>
                </x-slot>
            </x-master.item>
        </div>
    </div>
    <div class="grow-0">
        <div class="text-center">
            <a href="#detalle{{$vueloOrigen->id}}Modal" class="mx-2 badge badge-primary">1</a>
        </div>
        <x-master.modal id-modal="detalle{{$vueloOrigen->id}}Modal">
            <div class="flex justify-between">
                <div class="font-bold grow">
                  Datos del vuelo
                </div>
                <div class="grow-0">
                    <a href="#" class="font-bold">
                        <i class="la la-close"></i>
                    </a>
                </div>
            </div>
            <div>
                <x-master.item
                    label="Tiempo de vuelo"
                    sublabel="{{ \App\Services\VueloService::getTiempoVueloTotal($vueloOrigen, $vueloDestino) }}">
                    <x-slot name="avatar">
                        <i class="las la-clock"></i>
                    </x-slot>
                </x-master.item>

                <div class="text-lg font-bold">
                    Escala
                </div>

                <x-master.item
                    class="my-2"
                    label="Lugar de escala"
                    sublabel="{{optional($vueloOrigen->destino)->ubigeo_desc}}">
                    <x-slot name="avatar">
                        <i class="las la-map-marker"></i>
                    </x-slot>
                </x-master.item>
                <x-master.item
                    class="my-2"
                    label="Hora de llegada"
                    sublabel="{{optional($vueloOrigen->fecha_hora_aterrizaje_programado)->format('Y-m-d g:ia')}}">
                    <x-slot name="avatar">
                        <i class="las la-calendar"></i>
                    </x-slot>
                </x-master.item>
                <x-master.item
                    class="my-2"
                    label="Hora de salida"
                    sublabel="{{optional($vueloDestino->fecha_hora_vuelo_programado)->format('Y-m-d g:ia')}}">
                    <x-slot name="avatar">
                        <i class="las la-calendar"></i>
                    </x-slot>
                </x-master.item>
                <x-master.item
                    class="my-2"
                    label="Tiempo en escala"
                    sublabel="{{$vueloDestino->tiempo_vuelo}}">
                    <x-slot name="avatar">
                        <i class="las la-clock"></i>
                    </x-slot>
                </x-master.item>
            </div>
        </x-master.modal>
    </div>
    <div class="grow">
        <div class="p-3 bg-white rounded-t-lg rounded-box">
            <div class="mb-2">
                <span class="font-bold">Destino</span>
            </div>
            <x-item.ubicacion :ubicacion="$vueloDestino->destino">
                <x-slot name="avatar">
                    <i class="las la-plane-arrival"></i>
                </x-slot>
            </x-item.ubicacion>
            <x-master.item class="mt-5" label="Fecha de aterrizaje">
                <x-slot name="sublabel">
                    {{ optional($vueloDestino->fecha_hora_aterrizaje_programado)->format('Y-m-d g:i a') }} (Programado)
                    <br>
                    @if ($vueloDestino->hora_aterrizaje)
                        {{ optional($vueloDestino->hora_aterrizaje)->format('Y-m-d g:i a') }} (Real)
                    @endif
                </x-slot>
                <x-slot name="avatar">
                    <i class="las la-calendar"></i>
                </x-slot>
            </x-master.item>
        </div>
    </div>
</div>
