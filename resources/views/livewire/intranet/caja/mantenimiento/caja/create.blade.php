<x-master.modal id-modal="createCajaModal">
    <h4 class="text-lg font-semibold">Registro de caja</h4>
        <form wire:submit.prevent="save">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
            <div class="grid grid-cols-3 gap-4">
                <x-master.input name="form.serie" label="Serie" wire:model.defer="form.serie" type="text" placeholder="001"  required  ></x-master.input>
                <div class="col-span-2">
                    <x-master.select  name="form.tipo_caja_id" label="Tipo caja" wire:model.defer="form.tipo_caja_id" :options="$tipo_cajas" ></x-master.select>
                </div>
            </div>
            <x-master.select name="form.oficina_id" label="Oficina" wire:model.defer="form.oficina_id" :options="$oficinas" ></x-master.select>
            {{-- <x-master.select name="form.cajero_id" label="Cajero" wire:model.defer="form.cajero_id" :options="$cajeros" desc="nombre_completo"></x-master.select> --}}
            <x-master.input name="form.descripcion" label="Descripcion" wire:model.defer="form.descripcion" type="text"  required  ></x-master.input>
        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i> Guardar</button>
        </div>
    </form>

</x-master.modal>
