<x-master.modal id-modal="createTipoMotorModal">
    <h4 class="text-lg font-semibold">Registro de tipo_motor</h4>
        <form wire:submit.prevent="save">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
                                <x-master.input name="form.descripcion" label="Descripcion" wire:model.defer="form.descripcion" type="text"  required  ></x-master.input>


        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i> Guardar</button>
        </div>
    </form>

</x-master.modal>
