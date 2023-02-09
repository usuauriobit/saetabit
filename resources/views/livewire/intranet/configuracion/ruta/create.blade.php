<x-master.modal id-modal="createRutaModal">
    <h4 class="text-lg font-semibold">Registro de ruta</h4>
    <form wire:submit.prevent="save">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
            <x-master.select name="form.tipo_vuelo_id" label="Tipo vuelo" wire:model.defer="form.tipo_vuelo_id"
                :options="$tipo_vuelos"
                desc="desc_categoria"></x-master.select>
            <x-master.select name="form.tramo_id" label="Tramo" wire:model.defer="form.tramo_id" :options="$tramos">
            </x-master.select>

        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i>
                Guardar</button>
        </div>
    </form>

</x-master.modal>
