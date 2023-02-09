<div class="card-white">
    <div class="card-body">
        <div class="mb-4 text-xl font-bold">
            Registro de vuelo ::
            <span class="text-primary">{{ $tipo_vuelo->desc_categoria }}</span>
        </div>
        <div class="grid gap-4 lg:grid-cols-2">
            <div class="col-span-2">
                @if (!is_null($this->avion))
                    <x-master.item label="Avión" :sublabel="$this->avion->matricula">
                        <x-slot name="sublabel">
                            @if ($form['avion_id'])
                                <strong>Matrícula: </strong> {{ $this->avion->matricula }} <br>
                                <strong>Nro asientos: </strong> {{ $this->avion->nro_asientos }}
                            @else
                                <div class="badge badge-error">
                                    No seleccionado
                                </div>
                            @endif
                        </x-slot>
                        <x-slot name="avatar">
                            <i class="las la-plane"></i>
                        </x-slot>
                        <x-slot name="actions">
                            <button wire:click="removeAvion" class="btn btn-sm btn-danger">
                                <i class="las la-trash"></i>
                            </button>
                        </x-slot>
                    </x-master.item>
                @else
                    <livewire:intranet.comercial.vuelo.components.input-avion />
                @endif
            </div>
            @include('livewire.intranet.comercial.vuelo.components.create-simple.section-origen-destino')


            @if ($this->tipo_vuelo->is_no_regular)
                <x-master.input type="date" label="Fecha" wire:model.defer="form.fecha" name="form.fecha">
                </x-master.input>
            @else
                <x-master.input role="presentation" autocomplete="off" class="input_date"
                    label="Fecha y hora de despegue" wire:model.defer="form.fecha_hora_vuelo_programado"
                    name="form.fecha_hora_vuelo_programado">
                </x-master.input>
                <x-master.input role="presentation" autocomplete="off" class="input_date" label="Fecha de llegada"
                    wire:model.defer="form.fecha_hora_aterrizaje_programado"
                    name="form.fecha_hora_aterrizaje_programado">
                </x-master.input>
            @endif
        </div>

        @if ($this->is_no_regular && count($this->vuelos_generados_model) >= 1)
            <div class="mt-4 alert alert-info">
                <div>
                    <i class="la la-check"></i> &nbsp; Lista generada correctamente
                </div>
            </div>
        @else
            <button type="button" class="mt-4 btn btn-primary" wire:click="addVuelo" wire:loading.attr="disabled">
                <div wire:loading.remove>
                    <i class="text-md la la-plus"></i> &nbsp; Agregar
                </div>
                <div wire:loading style="margin-left: -60px;">
                    @include('components.loader-horizontal-sm', [($color = 'white')])
                </div>
            </button>
        @endif
    </div>
</div>
