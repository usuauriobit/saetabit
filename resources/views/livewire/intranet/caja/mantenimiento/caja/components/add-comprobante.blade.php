<x-master.modal id-modal="addComprobante">
    <h4 class="text-lg font-semibold">Registro de comprobante para caja</h4>
        <form wire:submit.prevent="save">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
            <x-master.input name="form.serie" label="Serie" wire:model.defer="form.serie" type="text" placeholder="001" required></x-master.input>
            <x-master.select  name="form.tipo_comprobante_id" label="Comprobante" wire:model.defer="form.tipo_comprobante_id" :options="$tipo_comprobantes" ></x-master.select>
        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i> Guardar</button>
        </div>
    </form>

</x-master.modal>
