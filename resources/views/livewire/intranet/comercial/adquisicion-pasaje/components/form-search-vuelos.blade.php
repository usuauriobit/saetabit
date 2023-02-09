<div
    class="border-box"
    style="
        background: url('{{ asset('img/default/colorful15.jpg') }}');
        background-size: cover;
        border-radius: 20px
    "
    >
    <div class="bg-white/70 border-box" style="
    border-radius: 20px">
        <div class="card-body">

            <h4 class="text-2xl font-bold">Buscar vuelos</h4>

            <div class="tabs tabs-boxed" >
                <a class="tab {{ $tab == 'filtro' ? 'tab-active' : ''}}" wire:click="setTab('filtro')">Por filtro</a>
                <a class="tab {{ $tab == 'codigo' ? 'tab-active' : ''}}" wire:click="setTab('codigo')">Por código</a>
            </div>

            @if ($tab == 'filtro')
                <div>
                    <x-master.select
                        :options="$tipo_vuelos"
                        desc="desc_categoria"
                        size-sm
                        label="Tipo de vuelo"
                        name="tipo_vuelo_id"
                        wire:model.defer="tipo_vuelo_id" >
                    </x-master.select>

                    @foreach (['origen', 'destino'] as $type)
                        @if ($this->$type)
                            <div class="my-2">
                                <div class="text-lg font-bold">
                                    {{ ucfirst($type) }}
                                </div>
                                <div class="card-white">
                                    <div class="py-3 mx-4">
                                        <x-item.ubicacion :ubicacion="$this->$type">
                                            <x-slot name="actions">
                                                <button wire:click="deleteUbicacion('{{$type}}')" type="button" class="btn btn-sm btn-danger">
                                                    <i class="la la-trash"></i>
                                                </button>
                                            </x-slot>
                                        </x-item.ubicacion>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mt-4">
                                <livewire:intranet.comercial.vuelo.components.input-ubicacion key="{{$type}}" type="{{$type}}" label="{{ ucfirst($type) }}" ></livewire:intranet.comercial.vuelo.components.input-ubicacion>
                            </div>
                        @endif
                    @endforeach
                    {{-- <div >
                        @if (!$destino && !$origen)
                            @if (!$rutaOpenned)
                                <button type="button" wire:click="toogleRutaOpenned" class="my-2 btn btn-sm btn-outline" >Seleccionar ruta predefinida</button>
                            @else
                                <div class="w-72">
                                    <livewire:intranet.comercial.vuelo.components.input-ruta  />
                                    <button type="button" wire:click="toogleRutaOpenned" class="btn btn-danger btn-sm">
                                        <i class="la la-trash"></i>
                                    </button>
                                </div>
                            @endif
                        @endif

                    </div> --}}

                    <div class="mt-4">
                        <div class="flex col-span-2">
                            <div class="mr-4 form-control">
                                <label class="cursor-pointer label">
                                    <input wire:model="type_search" type="radio" name="type" class="radio" value="ida_vuelta">
                                    <span class="ml-2 label-text">Ida y vuelta</span>
                                </label>
                            </div>
                            <div class="form-control">
                                <label class="cursor-pointer label">
                                    <input wire:model="type_search" type="radio" name="type" class="radio" value="ida">
                                    <span class="ml-2 label-text">Solo ida</span>
                                </label>
                            </div>
                        </div>
                        <x-master.input label="Fecha de ida" type="date" wire:model="fecha_ida" name="fecha_ida"></x-master.input>
                        @if ($type_search == 'ida_vuelta')
                            <x-master.input label="Fecha de vuelta" type="date" wire:model="fecha_vuelta" name="fecha_vuelta"></x-master.input>
                        @endif
                    </div>
                </div>
            @endif

            @if ($tab == 'codigo')
                <div class="py-5">
                    <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    type="text"
                    wire:model="codigo_vuelo"
                    placeholder="Escribe el código del vuelo" >
                </div>
            @endif

            <button class="mt-4 btn btn-primary" wire:click="searchVuelos" wire:loading.attr="disabled">
                <div wire:loading.remove>
                    <i class="text-lg la la-search"></i>&nbsp; Buscar vuelos
                </div>
                <div wire:loading style="margin-left: -60px;">
                    @include('components.loader-horizontal-sm', [$color = "white"])
                </div>
            </button>

            @if ($withPasajeAbiertoEmit && $destino && $origen && $tipo_vuelo_id)
                <button class="mt-3 btn btn-info" wire:click="setAsLibre">
                    Registrar pasaje con fecha abierta
                </button>
            @endif
        </div>
    </div>
</div>
