<x-master.modal id-modal="createAvionModal">
    <h4 class="text-lg font-semibold">Registro de avion</h4>
        <form wire:submit.prevent="save">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
                                <x-master.select name="form.tipo_motor_id" label="Tipo motor" wire:model.defer="form.tipo_motor_id" :options="$motors" ></x-master.select>
                    <x-master.select name="form.estado_avion_id" label="Estado avion" wire:model.defer="form.estado_avion_id" :options="$estados" ></x-master.select>
                    <x-master.select name="form.fabricante_id" label="Fabricante" wire:model.defer="form.fabricante_id" :options="$fabricantes" ></x-master.select>
                    <x-master.input name="form.nro_asientos" label="Nro asientos" wire:model.defer="form.nro_asientos" type="number"  required step='1' ></x-master.input>

                    <x-master.input name="form.nro_pilotos" label="Nro pilotos" wire:model.defer="form.nro_pilotos" type="number"  required step='1' ></x-master.input>

                    <x-master.input name="form.peso_max_pasajeros" label="Peso max pasajeros" wire:model.defer="form.peso_max_pasajeros" type="number"  required step='0.01' ></x-master.input>

                    <x-master.input name="form.peso_max_carga" label="Peso max carga" wire:model.defer="form.peso_max_carga" type="number"  required step='0.01' ></x-master.input>

                    <x-master.input name="form.fecha_fabricacion" label="Fecha fabricacion" wire:model.defer="form.fecha_fabricacion" type="date"  required  ></x-master.input>

                    <x-master.input name="form.descripcion" label="Descripcion" wire:model.defer="form.descripcion" type="text"  required  ></x-master.input>

                    <x-master.input name="form.modelo" label="Modelo" wire:model.defer="form.modelo" type="text"  required  ></x-master.input>

                    <x-master.input name="form.matricula" label="Matricula" wire:model.defer="form.matricula" type="text"  required  ></x-master.input>


        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i> Guardar</button>
        </div>
    </form>

</x-master.modal>
