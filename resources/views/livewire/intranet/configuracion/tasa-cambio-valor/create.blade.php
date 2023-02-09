<div>
    <h4 class="text-lg font-semibold">Registro de valor de la tasa de cambio</h4>

    <div class="grid gap-4 lg:grid-cols-2 xs:grid-cols-1">

        <div class="card-white mt-4">
            <div class="card-body">

                <form wire:submit.prevent="save">
                    <div wire:loading class="w-full">
                        <div class="loader">Cargando...</div>
                    </div>
                    <div wire:loading.remove>
                        <div>
                            <x-master.input name="form.fecha" type="date" label="Fecha"
                                wire:model.defer="form.fecha" />
                            <x-master.input name="form.valor_venta" type="number" step="0.0001" label="Valor"
                                wire:model.defer="form.valor_venta" />
                        </div>
                    </div>
                    <div class="modal-action">
                        <a href="#" class="btn btn-ghost">Cancelar</a>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i
                                class="la la-save"></i>
                            Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
