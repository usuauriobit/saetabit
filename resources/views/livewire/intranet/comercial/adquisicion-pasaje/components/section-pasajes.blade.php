<div class="">
    <div class="bg-white fade-in-fwd">
        <div class="card-body">
            @if ($this->canAddPasajes)
                <div>
                    <livewire:intranet.comercial.vuelo.components.form-pasajero key="formPasajero" :tipo-vuelo="$tipo_vuelo" />
                </div>
            @else
                <div class="py-4 text-center">

                    <div class="font-bold text-primary">
                        Ya no hay más asientos disponibles para los vuelos seleccionados.
                    </div>
                    <div class="text-grey-400">
                        Puedes continuar con los pasajes que has registrado hasta el momento
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="flex items-center justify-between">
        <div class="my-4 text-lg font-bold">
            Lista de pasajeros
        </div>
        @if (!$isLibre)
            <div>
                <span class="text-2xl font-bold text-primary">
                    {{ $this->nro_asientos_disponibles }}
                </span>
                Asientos disponibles para adquirir
            </div>
        @endif
    </div>

    @if (!$isLibre)
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-1">
            @foreach ($this->available_types as $type)
                <div class="mb-2 card-white" wire:key="SectionResumen{{ $type }}">
                    <div class="p-4"
                        style="background-image: url('{{ asset('img/default/colorful17.jpg') }}'); background-position:; background-repeat: no-repeat; background-size: cover;">
                        <x-item.vuelo-horizontal-simple wire:key="vueloIdaResumen{{ $type }}"
                            :vuelos="$this->{$type . '_vuelos_selected_model'}" />
                    </div>
                    <div class="card-body">
                        @foreach ($this->{$type . '_pasajes'} as $pasaje)
                            @include('livewire.intranet.comercial.adquisicion-pasaje.components.section-pasaje-info')
                            <hr class="my-2">
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @else
        @foreach ($pasajeros_libre as $pasaje)
            <div class="card-white">
                <div class="card-body">
                    @include('livewire.intranet.comercial.adquisicion-pasaje.components.section-pasaje-info')
                </div>
            </div>
        @endforeach
    @endif
</div>
