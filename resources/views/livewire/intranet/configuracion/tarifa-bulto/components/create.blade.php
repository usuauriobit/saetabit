<x-master.modal id-modal="createTarifaBultoModal">
    <h4 class="text-lg font-semibold">Registro de tarifa de exceso de equipajes / Traslado de mascotas</h4>
        <form wire:submit.prevent="save">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
            @if ($tarifa_bulto)
                <x-master.input name="form.peso_max" label="Peso máximo" wire:model.defer="form.peso_max" type="number" step="0.01"  required  ></x-master.input>
                <x-master.input name="form.monto_kg_excedido" label="{{ $tarifa_bulto->is_monto_fijo ? 'Monto referencial' : 'Monto por kg excedido' }}" wire:model.defer="form.monto_kg_excedido" type="number" step="0.01"  required  ></x-master.input>
                <div class="form-control mt-2">
                    <label class="label cursor-pointer">
                        <input type="checkbox" class="toggle" wire:model="form.is_monto_editable" />
                        <span class="label-text">¿Esta tarifa permite ser editado a discreción del usuario?</span>
                    </label>
                </div>
            @endif
        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i> Guardar</button>
        </div>
    </form>

</x-master.modal>
