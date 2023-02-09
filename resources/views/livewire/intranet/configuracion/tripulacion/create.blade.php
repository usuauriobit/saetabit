<x-master.modal id-modal="createTripulacionModal" label="Registro de tripulación">
    <form wire:submit.prevent="save" class="mt-4">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
            @if (!$this->persona)
                <livewire:intranet.components.input-persona/>
            @else
                <x-master.item label="Persona" sublabel="{{ $this->persona->nombre_completo }}">
                    <x-slot name="actions">
                        <button type="button" wire:click="deletePersona" class="btn btn-primary btn-outline">
                            <i class="la la-trash"></i>
                        </button>
                    </x-slot>
                </x-master.item>
            @endif
            <x-master.select name="form.tipo_tripulacion_id" label="Tipo tripulacion"
                wire:model.defer="form.tipo_tripulacion_id" :options="$tipo_tripulacions"></x-master.select>
            <x-master.input name="form.nro_licencia" label="Nro licencia" wire:model.defer="form.nro_licencia"
                type="text"></x-master.input>

            <x-master.input name="form.fecha_vencimiento_licencia" label="Fecha vencimiento licencia"
                wire:model.defer="form.fecha_vencimiento_licencia" type="date"></x-master.input>


        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i>
                Guardar</button>
        </div>
    </form>

</x-master.modal>
