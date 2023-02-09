@if (!$this->is_no_regular)
    <div>
        @if (is_null($this->origen))
            <livewire:intranet.comercial.vuelo.components.input-ubicacion label="Origen" type="origen" />
        @else
            <x-item.ubicacion :ubicacion="$this->origen">
                <x-slot name="actions">
                    <button type="button" class="btn btn-sm btn-danger" wire:click="removeUbicacionOrigen">
                        <i class="la la-trash"></i>
                    </button>
                </x-slot>
            </x-item.ubicacion>
        @endif
    </div>
    <div>
        @if (is_null($this->destino))
            <livewire:intranet.comercial.vuelo.components.input-ubicacion label="Destino" type="destino" />
        @else
            <x-item.ubicacion :ubicacion="$this->destino">
                <x-slot name="actions">
                    <button type="button" class="btn btn-sm btn-danger" wire:click="removeUbicacionDestino">
                        <i class="la la-trash"></i>
                    </button>
                </x-slot>
            </x-item.ubicacion>
        @endif
    </div>
@else

    @if ($this->is_ruta_selected)
        @if (!is_null($this->origen))
            <x-item.ubicacion :ubicacion="$this->origen">
            </x-item.ubicacion>
        @endif
        @if (!is_null($this->escala))
            <x-item.ubicacion :ubicacion="$this->escala">
            </x-item.ubicacion>
        @endif
        @if (!is_null($this->destino))
            <x-item.ubicacion :ubicacion="$this->destino">
            </x-item.ubicacion>
        @endif
        <div class="col-span-2">
            <button type="button" class="btn" wire:click="eliminarRuta">Volver a buscar ruta</button>
        </div>
    @else
        <div class="col-span-2">
            <livewire:intranet.comercial.vuelo.components.input-ruta type="no-regular" />
        </div>
    @endif


@endif
