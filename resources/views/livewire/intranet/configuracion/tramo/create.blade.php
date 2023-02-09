<x-master.modal id-modal="createTramoModal">
    <h4 class="text-lg font-semibold">Registro de tramo</h4>
    <form wire:submit.prevent="save">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
            <div class="my-2">
                @if ($origen)
                    <h4>Origen</h4>
                    <x-item.ubicacion :ubicacion="$origen">
                        <x-slot name="actions">
                            <button class="btn btn-danger btn-sm" wire:click="deleteUbicacion('origen')">
                                <i class="la la-trash"></i>
                            </button>
                        </x-slot>
                    </x-item.ubicacion>
                @else
                    <livewire:intranet.comercial.vuelo.components.input-ubicacion key="origenInput" type="origen" label="Origen" />
                @endif
            </div>
            <div class="my-2">
                @if ($escala)
                    <h4>Escala</h4>
                    <x-item.ubicacion :ubicacion="$escala">
                        <x-slot name="actions">
                            <button class="btn btn-danger btn-sm" wire:click="deleteUbicacion('escala')">
                                <i class="la la-trash"></i>
                            </button>
                        </x-slot>
                    </x-item.ubicacion>
                @else
                    <livewire:intranet.comercial.vuelo.components.input-ubicacion key="escalaInput" type="escala" label="Escala" />
                @endif
            </div>
            <div class="my-2">
                @if ($destino)
                    <h4>Destino</h4>
                    <x-item.ubicacion :ubicacion="$destino">
                        <x-slot name="actions">
                            <button class="btn btn-danger btn-sm" wire:click="deleteUbicacion('destino')">
                                <i class="la la-trash"></i>
                            </button>
                        </x-slot>
                    </x-item.ubicacion>
                @else
                    <livewire:intranet.comercial.vuelo.components.input-ubicacion key="destinoInput" type="destino" label="Destino" />
                @endif
            </div>
            <div class="my-2">
                <x-master.input type="number" step="0.1" label="Tiempo de vuelo (Minutos)" name="form.minutos_vuelo" wire:model.defer="form.minutos_vuelo"></x-master.input>
            </div>

            <div class="flex items-center mt-4">
                <input type="checkbox" wire:model="ida_vuelta" class="toggle">
                <div class="ml-4">
                    Ida y vuelta
                </div>
            </div>
            <div class="text-gray-500 text-sm">
                Se registrará otro tramo con los registros invertidos
            </div>

        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i>
                Guardar</button>
        </div>
    </form>

</x-master.modal>
