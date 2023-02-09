<x-master.modal id-modal="solicitarExtornoModal" w-size="4xl" label="Solicitud Extorno">
    <form wire:submit.prevent="storeExtorno">
        <div class="form-control">
            <label for="">Motivo</label>
            <textarea class="textarea textarea-bordered mb-2" wire:model.defer="form.motivo_extorno" name="form.motivo_extorno"></textarea>
            <button class="btn btn-success btn-sm">Guardar</button>
        </div>
    </form>
</x-master.modal>
