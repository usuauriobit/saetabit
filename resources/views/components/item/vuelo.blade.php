<div class="bg-white rounded">
    {{-- <div class="p-3 rounded-box" > --}}
    <div class="p-3 rounded-b-lg"
        {{-- style="
        z-index: -1;
         background: rgba(255, 255, 255, 0.52);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.068);
            backdrop-filter: blur(15.8px);
        " --}}
        >
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
                {{ optional($vuelo->fecha_hora_vuelo_programado)->format('Y-m-d H:i') }} (Programado)
                <br>
                @if ($vuelo->hora_despegue)
                    {{ optional($vuelo->hora_despegue)->format('Y-m-d H:i') }} (Real)
                @endif
            </x-slot>
            <x-slot name="avatar">
                <i class="las la-calendar"></i>
            </x-slot>
        </x-master.item>
    </div>
    <div class="text-center">
        <i class="text-4xl text-black las la-ellipsis-v"></i>

    </div>
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
                {{ optional($vuelo->fecha_hora_aterrizaje_programado)->format('Y-m-d H:i') }} (Programado)
                <br>
                @if ($vuelo->hora_aterrizaje)
                    {{ optional($vuelo->hora_aterrizaje)->format('Y-m-d H:i') }} (Real)
                @endif
            </x-slot>
            <x-slot name="avatar">
                <i class="las la-calendar"></i>
            </x-slot>
        </x-master.item>
    </div>
</div>
