@if (isset($vuelos['vuelta']['destino']['ubicacion']))
    <div class="p-2 bg-gray-50">
        <span class="font-bold text-secondary">Destino</span>
        <div>
            <x-item.ubicacion :ubicacion="$vuelos['vuelta']['destino']['ubicacion']">
                <div class="grid-cols-2 grip">
                    <x-master.input size-sm class="input_time" label="Hora de llegada"
                        name="vuelos.vuelta.destino.fecha_aterrizaje"
                        wire:model="vuelos.vuelta.destino.fecha_aterrizaje"></x-master.input>
                </div>
            </x-item.ubicacion>
        </div>
    </div>
@endif
