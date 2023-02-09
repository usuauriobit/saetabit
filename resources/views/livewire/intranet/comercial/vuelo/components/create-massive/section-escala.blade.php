@if (isset($vuelos['ida']['escala']['ubicacion']))
    <div x-show="$wire.vuelos.ida.origen.ubicacion" class="p-2 bg-gray-50">
        <span class="font-bold text-secondary">Escala</span>
        <div class="p-3 bg-gray-50 rounded-box">
            <x-item.ubicacion :ubicacion="$vuelos['ida']['escala']['ubicacion']">
                <div class="grid grid-cols-2 gap-4">
                    <x-master.input size-sm class="input_time" label="Hora de llegada"
                        name="vuelos.ida.escala.fecha_aterrizaje" wire:model="vuelos.ida.escala.fecha_aterrizaje">
                    </x-master.input>
                    <x-master.input size-sm class="input_time" label="Hora de despegue"
                        name="vuelos.ida.escala.fecha_despegue" wire:model="vuelos.ida.escala.fecha_despegue">
                    </x-master.input>
                </div>
            </x-item.ubicacion>
        </div>
    </div>
@endif
