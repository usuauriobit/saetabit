<x-master.modal id-modal="createCuentaBancariaReferencialModal">
    <h4 class="text-lg font-semibold">Registro de cuenta_bancaria_referencial</h4>
        <form wire:submit.prevent="save">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
                                <x-master.input name="form.nro_cuenta" label="Nro cuenta" wire:model.defer="form.nro_cuenta" type="text"  required  ></x-master.input>

                    <x-master.input name="form.descripcion_cuenta" label="Descripcion cuenta" wire:model.defer="form.descripcion_cuenta" type="text"  required  ></x-master.input>

                    <x-master.input name="form.glosa" label="Glosa" wire:model.defer="form.glosa" type="text"  required  ></x-master.input>


        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i> Guardar</button>
        </div>
    </form>

</x-master.modal>
