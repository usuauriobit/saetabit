<div class="">

    <div class="grid grid-cols-1 fade-in-fwd gap-4 p-4 lg:grid-cols-5 rounded-box"
        style="background-image: url('{{ asset('img/default/colorful15.jpg') }}'); background-position:; background-repeat: no-repeat; background-size: cover;">
        <div class="cols-span-5 lg:col-span-3">
            @include('livewire.intranet.comercial.adquisicion-pasaje.components.section-cliente')
        </div>
        <div class="cols-span-5 lg:col-span-2">
            @include('livewire.intranet.comercial.adquisicion-pasaje.components.section-monto-general')
        </div>
    </div>

    <div>
        <div class="my-4 text-lg font-bold">Relación de vuelos y pasajes</div>
    </div>

    <div>
        @if ($isLibre)
            @foreach ($pasajeros_libre as $pasaje)
                <div class="card-white">
                    <div class="card-body">
                        @include('livewire.intranet.comercial.adquisicion-pasaje.components.section-pasaje-resumen')
                    </div>
                </div>
            @endforeach
        @else
            @foreach ($this->available_types as $type)
                <div class="mb-2 card-white" wire:key="SectionResumen{{ $type }}">
                    <div class="p-4"
                        style="background-image: url('{{ asset('img/default/colorful17.jpg') }}'); background-position:; background-repeat: no-repeat; background-size: cover;">
                        <x-item.vuelo-horizontal-simple wire:key="vueloIdaResumen{{ $type }}"
                            :vuelos="$this->{$type . '_vuelos_selected_model'}" />
                    </div>
                    <div class="card-body">
                        @foreach ($this->{$type . '_pasajes'} as $pasaje)
                            {{-- {{var_dump($pasaje)}} --}}
                            {{-- {{var_dump($pasaje)}} ad --}}
                            {{-- <button wire:click="test">adws</button> --}}
                            <div wire:loading>
                                <div class="loader">Cargando...</div>
                            </div>
                            <div wire:loading.remove>
                                <livewire:intranet.comercial.adquisicion-pasaje.components.item-pasaje-resumen
                                    wire:key="{{ now() }}" nro="{{ $loop->iteration }}"
                                    type="{{ $type ?? 'libre' }}" isLibre="{{ $this->isLibre }}" :pasaje="$pasaje"
                                    :vueloOrigen="$this->{$type . '_vuelos_selected_model'}[0]" :pasajesAll="$this->{$type . '_pasajes'}" />
                                <hr class="my-2">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
