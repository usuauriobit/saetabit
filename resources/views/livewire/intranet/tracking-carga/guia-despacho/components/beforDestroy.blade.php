<x-master.modal id-modal="beforeDestroyModal">
    <h4 class="text-lg font-semibold">Anulación de Guía de Despacho</h4>
    <form wire:submit.prevent="destroy({{ $guia_despacho->id }})">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
            <x-master.select name="form.motivo_anulacion_id" label="Motivo de Anulación" wire:model.defer="form.motivo_anulacion_id" :options="$motivos_anulacion">
            </x-master.select>
            <x-master.input name="form.password" label="Confirmación de Contraseña" wire:model="form.password" type="password"  required>
            </x-master.input>
        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-error"
                onclick="confirm('¿Está seguro de eliminar? No podrá recuperarlo después')||event.stopImmediatePropagation()">
                Anular
            </button>
        </div>
    </form>

</x-master.modal>
