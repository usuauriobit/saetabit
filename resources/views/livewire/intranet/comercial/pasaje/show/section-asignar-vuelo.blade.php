<div x-data>
    <div class="mt-4 shadow-lg alert alert-info">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="flex-shrink-0 w-6 h-6 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Fecha límite para permitir cambio de fecha:
                <strong>{{ optional($pasaje->fecha_limite_cambio)->format('Y-m-d') }}</strong>
            </span>
        </div>
    </div>
    <div class="cabecera p-6">
        <x-master.item label="Registro de fecha abierta" sublabel="Historial de asignación de fecha abierta">
            <x-slot name="actions">
                @can('intranet.comercial.pasaje.cambio.fecha.create')
                    @if (!$pasaje->is_expired)
                        <a href="#createFechaAbiertaModal" class="btn btn-primary"> <i class="la la-plus"></i>
                            Registrar
                        </a>
                        <x-master.modal id-modal="createFechaAbiertaModal" w-size="2xl"
                            label="Registrar cambio de ruta">
                            <livewire:intranet.comercial.pasaje-cambio.create.fecha-abierta :pasaje="$pasaje" />
                        </x-master.modal>
                    @endif
                @endcan
            </x-slot>
        </x-master.item>
    </div>

    <div class="tabs tabs-boxed mt-4">
        @if ($pasaje->is_abierto)
            <a class="tab {{ $tab == 'formulario' ? 'tab-active' : '' }}" wire:click="setTab('formulario')">Formulario</a>
        @endif
        <a class="tab {{ $tab == 'historial' ? 'tab-active' : '' }}" wire:click="setTab('historial')">Historial</a>
    </div>
    <div class="cabecera p-6">
        <div x-show="$wire.tab == 'historial'">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha creación</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pasaje->pasaje_liberacion as $cod => $pl)
                            <tr>
                                <td>{{ $pl[0]->id }}</td>
                                <td>{{ $pl[0]->created_at->format('Y-m-d g:ia') }}</td>
                                <td>
                                    @if ($pl[0] && $pl[0]->is_abierto)
                                        <div class="badge badge-warning">Abierto</div>
                                    @else
                                        <div class="badge badge-success">Asignado</div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if ($pasaje->is_abierto)
            <div x-show="$wire.tab == 'formulario'" class="grid grid-cols-3 gap-4">
                <div class="card-white p-4 col-span-1">
                    <div class="mb-2">
                        <p class="mb-2">
                            <strong>Ingrese una fecha para buscar vuelos disponibles</strong>
                        </p>
                        <x-master.input label="Ingrese una fecha" type="date" wire:model.defer="fecha_filter"
                            name="fecha_filter">
                        </x-master.input>
                        @if (!$vuelos_selected)
                            <button type="button" class="w-full mt-4 btn btn-primary btn-outline"
                                wire:click="searchVuelos">
                                <i class="text-lg la la-search"></i> Buscar
                            </button>
                        @endif
                    </div>
                </div>
                <div class="col-span-2">
                    @if (!$vuelos_selected)
                        <div>
                            <span class="text-lg font-bold mt-2">{{ count($vuelos_founded) }} resultados encontrados</span>
                            @foreach ($vuelos_founded as $vuelos)
                                <livewire:intranet.comercial.adquisicion-pasaje.components.item-vuelo-select
                                    wire:key="itemFounded{{ now() }}" :vuelos="$vuelos"
                                    emitEvent="vueloSelectedRuta" :param-emit-event="$vuelos" />
                            @endforeach
                        </div>
                    @else
                        <div>
                            <div class="card-white">
                                <div class="px-4 py-4">
                                    <span class="text-lg font-bold">Vuelo seleccionado</span>
                                </div>
                                <x-item.vuelo-horizontal-simple wire:key="vueloSelectedRutaSimple" :vuelos="$this->vuelos_selected_model"
                                    transparent />
                            </div>
                            <button type="button" class="w-full mt-4 btn btn-primary" wire:click="save"
                                onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()">
                                <i class="text-lg la la-save"></i> Guardar
                            </button>
                            <button type="button" class="w-full mt-4 btn btn-primary btn-outline"
                                wire:click="deleteVuelosSelected">
                                <i class="text-lg la la-search"></i> Volver a buscar
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
