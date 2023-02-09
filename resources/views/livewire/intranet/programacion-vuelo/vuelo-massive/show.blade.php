<div>
    <div class="py-6">
        <x-master.item class="px-2" label="Historial de registro masivo de vuelos" sublabel="Lista de vuelos generados">
            <x-slot name="actions">
                @can('intranet.programacion-vuelo.vuelo-massive.delete')
                <div class="text-right">

                    <button class="btn btn-danger"
                        onclick="confirm('¿Está seguro de eliminar? No podrá recuperarlo después')||event.stopImmediatePropagation()"
                        wire:click="destroy">
                        <i class="la la-trash"></i> &nbsp;
                        Eliminar
                    </button>
                    <p>
                        Solo se eliminarán los vuelos que no tienen relación de pasajeros, guías despacho, etc.
                        <br>
                        <strong>Si todos los vuelos pueden eliminarse, todo el historial será eliminado</strong>
                    </p>
                </div>
                @endcan
                {{-- <div class="flex items-end gap-4">
                    <x-master.select
                        wire:model="filterSelected"
                        label="Filtrar por"
                        :options="$filterOptions"
                    />
                    @can('intranet.comercial.pasaje.create')
                        <a href="{{ route('intranet.comercial.adquisicion-pasaje.create') }}"
                            class="btn btn-primary"> <i class="la la-plus"></i> Agregar</a>
                    @endcan
                </div> --}}
            </x-slot>
        </x-master.item>
    </div>
    <div class="mb-6 card-white">
        <div class="grid grid-cols-1 gap-4 p-6 lg:grid-cols-5">
            <div class="col-span-5 lg:col-span-2">
                <div class="text-xl font-semibold text-gray-500">
                    {{ $vuelo_massive->tipo_vuelo->desc_categoria }}
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-master.item class="my-3" label="Desde" sublabel="{{ $vuelo_massive->fecha_inicio->format('d-m-Y') }}"></x-master.item>
                    <x-master.item class="my-3" label="Hasta" sublabel="{{ $vuelo_massive->fecha_final->format('d-m-Y') }}"></x-master.item>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-master.item class="my-3" label="N° Asientos" sublabel="{{ $vuelo_massive->nro_asientos }}"></x-master.item>
                    <x-master.item class="my-3" label="Paquete" sublabel="{{ $vuelo_massive->paquete }}"></x-master.item>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-master.item class="my-3" label="N° Contrato" sublabel="{{ $vuelo_massive->nro_contrato }}"></x-master.item>
                    <x-master.item class="my-3" label="Cliente" sublabel="{{ optional($vuelo_massive->cliente)->razon_social }}"></x-master.item>
                </div>
            </div>
            <div class="col-span-5 lg:col-span-3">
                <x-item.ruta :ruta="$vuelo_massive->ruta"/>
            </div>
        </div>
    </div>
    <div class="col-span-2 card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Matrícula Avión</th>
                        <th>Origen</th>
                        <th>Salida</th>
                        <th>Destino</th>
                        <th>Llegada</th>
                        <th>Tiempo de Vuelo</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($row->avion)->matricula }}</td>
                            <td>
                                <strong>
                                    {{ optional($row->origen)->codigo_iata }}
                                </strong>
                                <p class="text-gray-500">
                                    {{ optional(optional($row->origen)->ubigeo)->distrito }}
                                </p>
                            </td>
                            <td>
                                {{ optional($row->fecha_hora_vuelo_programado)->format('Y-m-d') }} <br>
                                {{ optional($row->fecha_hora_vuelo_programado)->format('H:i') }}
                            </td>
                            <td>
                                <strong>
                                    {{ optional($row->destino)->codigo_iata }}
                                </strong>
                                <p class="text-gray-500">
                                    {{ optional(optional($row->destino)->ubigeo)->distrito }}
                                </p>
                            </td>
                            <td>
                                {{ optional($row->fecha_hora_aterrizaje_programado)->format('Y-m-d') }} <br>
                                {{ optional($row->fecha_hora_aterrizaje_programado)->format('H:i') }}
                            </td>
                            <td>{{ $row->tiempo_vuelo }}</td>
                            <td>
                                @include('livewire.intranet.comercial.vuelo.components.vuelo-status', ['vuelo' => $row])
                                <br>
                                @if ($row->can_delete)
                                    <div class="badge badge-success">Se puede eliminar</div>
                                @else
                                    <div class="badge badge-info">Ya no se puede eliminar</div>
                                @endif
                            </td>
                            <td class="w-3">
                                <a href="{{ route('intranet.programacion-vuelo.vuelo.show', $row) }}"
                                    class="btn btn-circle btn-sm btn-success">
                                    <i class="la la-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
