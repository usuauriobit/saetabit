<x-master.modal id-modal="createTiempoTramoModal">
    <h4 class="text-lg font-semibold">Registro de tiempo_tramo</h4>
    <form wire:submit.prevent="save">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
            <x-master.select name="form.tramo_id" label="Tramo" wire:model.defer="form.tramo_id" :options="$tramos">
            </x-master.select>
            <x-master.select name="form.avion_id" label="Avion" wire:model.defer="form.avion_id" :options="$avions">
            </x-master.select>
            <x-master.input name="form.tiempo_vuelo" label="Tiempo vuelo (min)" wire:model.defer="form.tiempo_vuelo"
                type="number" required step='1'></x-master.input>


        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i>
                Guardar</button>
        </div>
    </form>

</x-master.modal>
