<div class="card-white my-2">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 items-center">
        <div class="bg-gray-100 p-4">
            <x-master.item label="Fecha" sublabel="{{ optional($vuelo->fecha_hora_aterrizaje_programado)->format('Y-m-d') }}">
                <x-slot name="avatar">
                    <i class="la la-calendar"></i>
                </x-slot>
            </x-master.item>
        </div>
        <div class="p-4">
            <x-master.item sublabel="{{ optional($vuelo->fecha_hora_vuelo_programado)->format('Y-m-d') }}">
                <x-slot name="avatar">
                    <i class="las la-plane-departure"></i>
                </x-slot>
                <x-slot name="label">
                    <div class="text-lg font-bold text-primary">{{ $vuelo->origen->codigo_default }}</div>
                </x-slot>
                <x-slot name="sublabel">
                    <div class="font-bold">{{ optional(optional($vuelo->origen)->ubigeo)->distrito }}</div>
                    <div>{{ optional($vuelo->fecha_hora_vuelo_programado)->format('g:i a') }}</div>
                </x-slot>
            </x-master.item>
        </div>
        <div>
            <div class="text-center my-auto">
                <i class="las la-arrow-right"></i>
                <br>
                2h 34 min
            </div>
        </div>
        <div class="p-4">
            <x-master.item sublabel="{{ optional($vuelo->fecha_hora_aterrizaje_programado)->format('Y-m-d') }}">
                <x-slot name="avatar">
                    <i class="las la-plane-arrival"></i>
                </x-slot>
                <x-slot name="label">
                    <div class="text-lg font-bold text-primary">{{ $vuelo->destino->codigo_default }}</div>
                </x-slot>
                <x-slot name="sublabel">
                    <div class="font-bold">{{ optional(optional($vuelo->destino)->ubigeo)->distrito }}</div>
                    <div>{{ optional($vuelo->fecha_hora_aterrizaje_programado)->format('g:i a') }}</div>
                </x-slot>
            </x-master.item>
        </div>
        <div>
            {{$action}}
        </div>
    </div>
</div>
