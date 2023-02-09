<div class=" {{$transparent ? '' : 'card-white' }} ">
    <div class="p-4 bg-gray-50">
        <div class="flex items-center justify-between">
            @if (!$hideCodigo)
                <x-master.item label="COD">
                    <x-slot name="sublabel">
                        {{ $vueloOrigen->codigo }}
                        @include('livewire.intranet.components.badge-tipo-vuelo', ['tipo_vuelo' => $vueloOrigen->tipo_vuelo])
                    </x-slot>
                    {{-- <x-slot name="avatar">
                        <i class="la la-calendar"></i>
                    </x-slot> --}}
                </x-master.item>
            @endif
            <x-master.item label="Fecha" sublabel="{{ optional($vueloOrigen->fecha_hora_aterrizaje_programado)->format('Y-m-d') }}">
                <x-slot name="avatar">
                    <i class="la la-calendar"></i>
                </x-slot>
            </x-master.item>
            @if (!$hideAsientosDisponibles)
                <div>
                    <span class="text-xl font-bold text-primary">{{ $asientos_disponibles }}</span>
                    <span class="text-grey-400">
                        Asientos
                        <br>
                        disponibles
                    </span>
                </div>
            @endif
            <div class="my-auto">
                @if ($showInfo)
                    <a href="#detalle{{$vueloOrigen->id}}Modal" class="mr-2">
                        <i class="text-2xl las la-question-circle"></i>
                    </a>
                @endif
                {{$slot}}
            </div>
        </div>
    </div>
    <div class="flex items-center justify-between gap-4 p-4 ">
        <div class="pl-2">
            <x-master.item sublabel="{{ optional($vueloOrigen->fecha_hora_vuelo_programado)->format('Y-m-d') }}">
                <x-slot name="avatar">
                    <i class="text-2xl las la-plane-departure"></i>
                </x-slot>
                <x-slot name="label">
                    <div class="text-lg font-bold text-primary">{{ $vueloOrigen->origen->codigo_default }}</div>
                </x-slot>
                <x-slot name="sublabel">
                    <div class="font-bold">{{ optional(optional($vueloOrigen->origen)->ubigeo)->distrito }}</div>
                    <div>
                        @if (optional($vueloOrigen->fecha_hora_vuelo_programado)->format('g:i a') === '12:00 am')
                            -
                        @else
                            {{ optional($vueloOrigen->fecha_hora_vuelo_programado)->format('g:i a') }}
                        @endif
                    </div>
                </x-slot>
            </x-master.item>
        </div>
        <div>
            <div class="my-auto text-center">
                @if ($hasEscala)
                    <div class="badge badge-accent">1 escala</div>
                @else
                    <i class="text-lg las la-arrow-right"></i>
                @endif
                <br>
                {{-- {{ var_dump($vueloOrigen) }} --}}
                {{-- {{ var_dump($vueloDestino->fecha_hora_aterrizaje_programado) }} --}}
                {{ \App\Services\VueloService::getTiempoVueloTotal($vueloOrigen, $vueloDestino) }}
            </div>
        </div>
        <div class="">
            <x-master.item sublabel="{{ optional($vueloDestino->fecha_hora_aterrizaje_programado)->format('Y-m-d') }}">
                <x-slot name="avatar">
                    <i class="text-2xl las la-plane-arrival"></i>
                </x-slot>
                <x-slot name="label">
                    <div class="text-lg font-bold text-primary">{{ $vueloDestino->destino->codigo_default }}</div>
                </x-slot>
                <x-slot name="sublabel">
                    <div class="font-bold">{{ optional(optional($vueloDestino->destino)->ubigeo)->distrito }}</div>
                    <div>
                        @if (optional($vueloDestino->fecha_hora_aterrizaje_programado)->format('g:i a') === '12:00 am')
                            -
                        @else
                            {{ optional($vueloDestino->fecha_hora_aterrizaje_programado)->format('g:i a') }}
                        @endif
                    </div>
                </x-slot>
            </x-master.item>
        </div>

    </div>

    <x-master.modal id-modal="detalle{{$vueloOrigen->id}}Modal" label="Datos del vuelo">
        <div>
            <x-master.item
                label="Tiempo de vuelo"
                sublabel="{{ \App\Services\VueloService::getTiempoVueloTotal($vueloOrigen, $vueloDestino) }}"
            >
                <x-slot name="avatar">
                    <i class="las la-clock"></i>
                </x-slot>
            </x-master.item>

            @if ($hasEscala)
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
                    label="Hora de llegada a la escala"
                    sublabel="{{optional($vueloOrigen->fecha_hora_aterrizaje_programado)->format('Y-m-d g:ia')}}">
                    <x-slot name="avatar">
                        <i class="las la-calendar"></i>
                    </x-slot>
                </x-master.item>
                <x-master.item
                    class="my-2"
                    label="Hora de salida de la escala"
                    sublabel="{{optional($vueloDestino->fecha_hora_vuelo_programado)->format('Y-m-d g:ia')}}">
                    <x-slot name="avatar">
                        <i class="las la-calendar"></i>
                    </x-slot>
                </x-master.item>
                {{-- <x-master.item
                    class="my-2"
                    label="Tiempo en escala"
                    sublabel="{{$vueloDestino->tiempo_vuelo}}">
                    <x-slot name="avatar">
                        <i class="las la-clock"></i>
                    </x-slot>
                </x-master.item> --}}
            @endif
        </div>
    </x-master.modal>
</div>
