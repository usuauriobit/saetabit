<div class="flex justify-between gap-4">
    <x-master.select
        wire:model="filter.tipo_vuelo_id"
        label="Tipo de vuelo"
        :options="$filterCategoriaOptions"
    />
    <div>
        <div class="flex items-end gap-4">
            <x-master.input
                wire:model="filter.fecha_inicio"
                label="Fecha de inicio"
                type="date"
            />
            <x-master.input
                wire:model="filter.fecha_final"
                label="Fecha final"
                type="date"
            />
        </div>
    </div>
</div>
<div class="flex items-end gap-4 mt-4">
    <div class="w-80">
        @if (!$this->origen_model)
            <livewire:intranet.comercial.vuelo.components.input-ubicacion nameEvent="origenSetted" label="Ubicación origen"/>
        @else
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
        @endif
    </div>
    <div class="w-80">
        @if (!$this->destino_model)
            <livewire:intranet.comercial.vuelo.components.input-ubicacion nameEvent="destinoSetted" label="Ubicación destino"/>
        @else
            <div class="text-primary">
                <x-master.item label="Origen">
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
        @endif
    </div>
</div>
