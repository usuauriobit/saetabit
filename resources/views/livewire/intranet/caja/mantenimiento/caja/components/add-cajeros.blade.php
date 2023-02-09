<x-master.modal id-modal="addCajeros">
    <h4 class="text-lg font-semibold">Registro de cajeros</h4>
        <form wire:submit.prevent="asignarCajeros">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        {{-- {{ var_dump($array_cajeros) }} --}}
        <div wire:loading.remove>
            <x-master.multi-select wire:model.defer="array_cajeros" :options="$cajeros" label="Cajeros"/>
        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i> Guardar</button>
        </div>
    </form>
</x-master.modal>
