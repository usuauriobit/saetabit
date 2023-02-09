<div>
    <div class="grid grid-cols-1 gap-6 my-4 lg:grid-cols-3">
        <div>
            <x-master.item label="Pasajero" class="mb-2">
                <x-slot name="avatar">
                    <i class="la la-user"></i>
                </x-slot>
                <x-slot name="sublabel">
                    {{ $persona->nombre_completo }}
                    <div class="font-bold text-gray-500">
                        {{ $persona->nro_doc }}
                    </div>
                </x-slot>
                <x-slot name="actions">
                    <button type="button" class="btn btn-sm btn-danger" wire:click="deletePasajero">
                        <i class="la la-times"></i>
                    </button>
                </x-slot>
            </x-master.item>
            @if ($this->tipo_pasaje)
                <x-master.item label="Tipo de pasajero">
                    <x-slot name="avatar">
                        <i class="la la-list"></i>
                    </x-slot>
                    <x-slot name="sublabel">
                        <div class="text-lg font-bold text-gray-500">
                            {{ $this->tipo_pasaje->abreviatura }}
                        </div>
                        {{ $this->tipo_pasaje->descripcion }}
                    </x-slot>
                </x-master.item>
            @endif
        </div>
        <div>
            <x-master.input label="Peso estimado" type="number" step="0.01" wire:model.defer="form.peso_estimado"
                name="form.peso_estimado">
                <x-slot name="suffix">
                    <span>Kg</span>
                </x-slot>
            </x-master.input>
            <x-master.select :options="[['id' => 1, 'desc' => 'Masculino'], ['id' => 0, 'desc' => 'Femenino']]" desc="desc" label="Sexo" wire:model.defer="form.sexo"
                name="form.sexo">
            </x-master.select>
            <x-master.input label="Fecha de nacimiento" disabled type="date"
                wire:model.debounce.2000ms="form.fecha_nacimiento" name="form.fecha_nacimiento">
                <x-slot name="altLabelBL">
                    Edad: {{ $this->edad }}
                </x-slot>
            </x-master.input>
        </div>
        <div>
            <x-master.input label="Teléfono" wire:model.defer="form.telefono" name="form.telefono" step="1"
                type="number" />
            <x-master.input label="Email" wire:model.defer="form.email" name="form.email" type="email" />
            <x-master.input label="Descripción extra" wire:model.defer="form.descripcion" name="form.descripcion" />
        </div>
    </div>
    <button type="submit" wire:loading.attr="disabled" class="w-full mt-4 btn btn-primary">
        <i class="la la-plus"></i> &nbsp; Agregar
    </button>
</div>
