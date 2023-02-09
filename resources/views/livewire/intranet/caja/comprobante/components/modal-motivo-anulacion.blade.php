<x-master.modal id-modal="motivoAnulacionModal" w-size="4xl" label="Motivo de Anulación de Comprobante">
    <form wire:submit.prevent="anularComprobante">
        <div class="form-control">
            <label for="">Motivo</label>
            <textarea class="mb-2 textarea textarea-bordered" wire:model.defer="form.motivo_anulacion" name="form.motivo_anulacion"></textarea>
            <button class="btn btn-success btn-sm" onclick="confirm('¿Está seguro de anular el comprobante? No podrá recuperarlo después')||event.stopImmediatePropagation()">
                Guardar
            </button>
        </div>
    </form>
</x-master.modal>
