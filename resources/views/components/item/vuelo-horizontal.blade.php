<div class="flex items-center">
    <div class="grow">
        <div class="p-3 bg-white rounded-box rounded-t-lg">
            <div class="mb-2">
                <span class="font-bold">Origen</span>
            </div>
            <x-item.ubicacion :ubicacion="$vuelo->origen">
                <x-slot name="avatar">
                    <i class="las la-plane-departure"></i>
                </x-slot>
            </x-item.ubicacion>
            <x-master.item class="mt-5" label="Fecha de vuelo">
                <x-slot name="sublabel">
                    {{ optional($vuelo->fecha_hora_vuelo_programado)->format('Y-m-d g:i a') }} (Estimado)
                    <br>
                    @if ($vuelo->hora_despegue)
                        {{ optional($vuelo->hora_despegue)->format('Y-m-d g:i a') }} (Real)
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
            <a href="#detalleSimple{{ $vuelo->id }}Modal">
                <i class="text-4xl text-black las la-ellipsis-h"></i>
            </a>
        </div>
        <x-master.modal id-modal="detalleSimple{{ $vuelo->id }}Modal">
            <div class="flex justify-between">
                <div class="grow font-bold">
                    Datos del vuelo
                </div>
                <div class="grow-0">
                    <a href="#" class="font-bold">
                        <i class="la la-close"></i>
                    </a>
                </div>
            </div>
            <div>
                <x-master.item label="Tiempo de vuelo" sublabel="{{ $vuelo->tiempo_vuelo }}">
                    <x-slot name="avatar">
                        <i class="las la-clock"></i>
                    </x-slot>
                </x-master.item>
            </div>
        </x-master.modal>
    </div>
    <div class="grow">
        <div class="p-3 bg-white rounded-box rounded-t-lg">
            <div class="mb-2">
                <span class="font-bold">Destino</span>
            </div>
            <x-item.ubicacion :ubicacion="$vuelo->destino">
                <x-slot name="avatar">
                    <i class="las la-plane-arrival"></i>
                </x-slot>
            </x-item.ubicacion>
            <x-master.item class="mt-5" label="Fecha de aterrizaje">
                <x-slot name="sublabel">
                    {{ optional($vuelo->fecha_hora_aterrizaje_programado)->format('Y-m-d g:i a') }} (Estimado)
                    <br>
                    @if ($vuelo->hora_aterrizaje)
                        {{ optional($vuelo->hora_aterrizaje)->format('Y-m-d g:i a') }} (Real)
                    @endif
                </x-slot>
                <x-slot name="avatar">
                    <i class="las la-calendar"></i>
                </x-slot>
            </x-master.item>
        </div>
    </div>
</div>
