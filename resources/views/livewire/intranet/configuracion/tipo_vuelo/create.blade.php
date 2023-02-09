<x-master.modal id-modal="createTipoVueloModal">
    <h4 class="text-lg font-semibold">Registro de tipo_vuelo</h4>
        <form wire:submit.prevent="save">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
                                <x-master.select name="form.categoria_vuelo_id" label="Categoria vuelo" wire:model.defer="form.categoria_vuelo_id" :options="$categoria_vuelos" ></x-master.select>
                    <x-master.input name="form.descripcion" label="Descripcion" wire:model.defer="form.descripcion" type="text"  required  ></x-master.input>


        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i> Guardar</button>
        </div>
    </form>

</x-master.modal>
