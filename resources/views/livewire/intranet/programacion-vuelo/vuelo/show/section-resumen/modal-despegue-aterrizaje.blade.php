<x-master.modal id-modal="setMonitoreo" label="Registro de monitoreo">
    <form wire:submit.prevent="setMonitoreo" wire:ignore>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Hora de vuelo</span>
            </label>
            <label class="input-group">
                <input
                    class="input w-full input-bordered"
                    x-data
                    x-init="flatpickr($refs.input, {
                        enableTime: true,
                        noCalendar: false,
                        dateFormat: 'Y-m-d H:i',
                    })"
                    x-ref="input"
                    type="text"
                    data-input
                    wire:model.defer="monitoreo_form.hora_despegue"
                />
            </label>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Hora de aterrizaje</span>
            </label>
            <label class="input-group">
                <input
                    class="input w-full input-bordered"
                    x-data
                    x-init="flatpickr($refs.input, {
                        enableTime: true,
                        noCalendar: false,
                        dateFormat: 'Y-m-d H:i',
                    })"
                    x-ref="input"
                    type="text"
                    data-input
                    wire:model.defer="monitoreo_form.hora_aterrizaje"
                />
            </label>
        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i>
                Guardar</button>
        </div>
    </form>
</x-master.modal>
