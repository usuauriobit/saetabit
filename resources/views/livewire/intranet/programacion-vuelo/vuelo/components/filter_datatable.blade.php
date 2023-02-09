<div class="">
    <div class="flex justify-between gap-4">
        <div class="w-48">
            <x-master.select wire:model="categoriaId" label="Filtrar por" :options="$filterOptions" />
        </div>
        <div class="flex items-end gap-4">
            <x-master.input wire:model="desde" label="Desde" type="date" />
            <x-master.input wire:model="hasta" label="Hasta" type="date" />
            {{-- <x-master.input wire:model="fecha" label="Fecha" type="date" /> --}}
            {{-- <x-master.input wire:model="from" label="Fecha de inicio" type="date" />
            <x-master.input wire:model="to" label="Fecha final" type="date" /> --}}
        </div>
    </div>
    <div>
        <div class="flex items-end gap-4 mt-4">

            <div class="w-96">
                @if (!$this->origen_model)
                    <livewire:intranet.comercial.vuelo.components.input-ubicacion nameEvent="origenSetted"
                        label="Ubicación origen" />
                @else
                    <div class="card-white p-4">
                        <div class="text-primary">
                            <x-master.item label="Origen">
                                <x-slot name="avatar">
                                    <i class="las la-circle"></i>
                                </x-slot>
                            </x-master.item>
                        </div>
                        <x-item.ubicacion :ubicacion="$this->origen_model">
                            <x-slot name="actions">
                                <button class="btn btn-sm" wire:click="deleteUbicacion('origen')">
                                    <i class="la la-trash"></i>
                                </button>
                            </x-slot>
                        </x-item.ubicacion>
                    </div>
                @endif
            </div>
            <div class="w-96">
                @if (!$this->destino_model)
                    <livewire:intranet.comercial.vuelo.components.input-ubicacion nameEvent="destinoSetted"
                        label="Ubicación destino" />
                @else
                    <div class="card-white p-4">
                        <div class="text-primary">
                            <x-master.item label="Destino">
                                <x-slot name="avatar">
                                    <i class="las la-circle"></i>
                                </x-slot>
                            </x-master.item>
                        </div>
                        <x-item.ubicacion :ubicacion="$this->destino_model">
                            <x-slot name="actions">
                                <button class="btn btn-sm" wire:click="deleteUbicacion('destino')">
                                    <i class="la la-trash"></i>
                                </button>
                            </x-slot>
                        </x-item.ubicacion>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
