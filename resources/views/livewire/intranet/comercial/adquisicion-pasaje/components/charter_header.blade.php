<div class="p-4 mb-3 card-white">
    <x-master.item labelSize="xl" class="boder">
        <x-slot name="label">
            Registro de pasajeros para vuelos Chárter
        </x-slot>
        <x-slot name="sublabel">
            Registro de pasajeros para vuelos Chárter
        </x-slot>
        <x-slot name="actions">
            <button class="btn btn-primary" type="button" {{ !$this->has_pasajes ? 'disabled' : '' }}
                onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()" wire:click="save">
                Guardar
                <i class="las la-save"></i>
            </button>
        </x-slot>
    </x-master.item>
</div>
