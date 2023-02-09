<div x-data="{ tab: 'pasajeros' }">
    <div class="p-3"
        style="background-image: url('{{ asset('img/default/colorful15.jpg') }}'); background-position:; background-repeat: no-repeat; background-size: cover;">
        <div class="mb-2 text-xl font-bold text-white">
            Vuelos en ruta

            @if ($vuelo_ruta->vuelos[0]->is_charter)
                <div class="p-2 badge badge-accent">CHÁRTER</div>
            @endif
        </div>
        <x-item.vuelo-horizontal-simple :vuelos="$vuelo_ruta->vuelos"></x-item.vuelo-horizontal-simple>
    </div>

    <div class="">
        <div class="bg-white">
            <div class="w-full tabs tabs-boxed">
                <a class="tab " @click="tab = 'pasajeros'" :class="{ 'tab-active ': tab == 'pasajeros' }">Pasajeros</a>
                <a class="tab " @click="tab = 'vuelo-ruta'" :class="{ 'tab-active ': tab == 'vuelo-ruta' }">Vuelos en
                    ruta</a>
                <a class="tab " @click="tab = 'incidencias'"
                    :class="{ 'tab-active ': tab == 'incidencias' }">Incidencias</a>
            </div>
        </div>
    </div>
    <div class="mt-4">

        <div class="card-body">
            <div x-show="tab == 'pasajeros'" x-transition:enter.duration.500ms>
                @include('livewire.intranet.programacion-vuelo.vuelo-ruta.components.tab-pasajeros')
            </div>
            <div x-show="tab == 'vuelo-ruta'" x-transition:enter.duration.500ms>
                @include('livewire.intranet.programacion-vuelo.vuelo-ruta.components.tab-vuelo-ruta')
            </div>
            <div x-show="tab == 'incidencias'" x-transition:enter.duration.500ms>
                @include('livewire.intranet.programacion-vuelo.vuelo-ruta.components.tab-incidencias')
            </div>
        </div>
    </div>

    {{-- <div class="grid grid-cols-1 lg:grid-cols-4">
        <div class="col-span-1 p-2"
            style="
            background: rgb(39,63,140);
            background: linear-gradient(149deg, rgba(39,63,140,1) 0%, rgba(28,28,163,1) 38%, rgba(57,153,193,1) 100%);
            "
        >

            <div class="my-2 card-white">
                <div class="card-body">
                    @if (!$vuelo_selected)
                        <button class="btn btn-primary btn-outline" wire:click="emptyVueloSelected">
                            <i class="text-xl la la-list"></i> Resumen general
                        </button>
                    @else
                        <div class="text-primary">
                            <i class="text-xl la la-list"></i> Resumen general
                        </div>
                    @endif
                </div>
            </div>
            <div class="mb-2 font-bold text-center text-white">
                Ruta de vuelos ({{$vuelo_ruta->vuelos->count()}})
            </div>
            @foreach ($vuelo_ruta->vuelos as $vuelo)
                <div class="">
                    <a href="#" wire:click="setVueloSelected({{$vuelo->id}})">
                        <div class="{{ !is_null($vuelo_selected) && $vuelo->id == $vuelo_selected->id ? 'rounded-md border-4 border-accent ' : ''}}">
                            <x-item.card-vuelo-simple :vuelo="$vuelo" ></x-item.card-vuelo-simple>
                        </div>
                    </a>
                    @if (!$loop->last)
                        <div class="text-center">
                            <i class="text-2xl text-white las la-angle-down"></i>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="col-span-3">
            @if ($vuelo_selected)
                <div>
                    <livewire:intranet.comercial.vuelo.show key="{{now()}}" contain :vuelo="$vuelo_selected"></livewire:intranet.comercial.vuelo.show>
                </div>
            @endif
        </div>
    </div> --}}
</div>
