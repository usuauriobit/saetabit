<div>
    @if (!$vuelo->avion)
        <livewire:intranet.comercial.vuelo.components.input-avion min-asientos="{{ $vuelo->nro_asientos_ofertados }}"/>
    @else
        <div class="card-white">
            <div class="card-body">
                <div class="grid items-center grid-cols-2 gap-4">
                    <div>
                        <div class="text-center">
                            <img src="{{ asset('img/repo/plane-1.png') }}" width="300px" alt="">
                        </div>
                        <div class="text-center">
                            <br>
                            @if (!$vuelo->is_closed)
                                <button class="btn btn-outline btn-primary" wire:click="deleteAvion">Volver a elegir</button>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Descripcion" :sublabel="$vuelo->avion->descripcion"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Matricula" :sublabel="$vuelo->avion->matricula"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Modelo" :sublabel="$vuelo->avion->modelo"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Tipo motor" :sublabel="optional($vuelo->avion->motor)->descripcion"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Estado avion" :sublabel="optional($vuelo->avion->estado)->descripcion"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Fabricante" :sublabel="optional($vuelo->avion->fabricante)->descripcion"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Nro asientos" :sublabel="$vuelo->avion->nro_asientos"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Nro pilotos" :sublabel="$vuelo->avion->nro_pilotos"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Peso max pasajeros" :sublabel="$vuelo->avion->peso_max_pasajeros"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Peso max carga" :sublabel="$vuelo->avion->peso_max_carga"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Fecha fabricacion" :sublabel="$vuelo->avion->fecha_fabricacion"></x-master.item>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
