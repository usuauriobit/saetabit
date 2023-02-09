@if (isset($vuelos['ida']['origen']['ubicacion']))
    <div class="p-2 bg-gray-50">
        <span class="font-bold text-secondary">Origen</span>
        <x-item.ubicacion :ubicacion="$vuelos['ida']['origen']['ubicacion']">
            <x-master.input size-sm class="input_time" label="Hora de despegue" name="vuelos.ida.origen.fecha_despegue"
                wire:model="vuelos.ida.origen.fecha_despegue"
            >
            </x-master.input>
        </x-item.ubicacion>
    </div>
@endif
