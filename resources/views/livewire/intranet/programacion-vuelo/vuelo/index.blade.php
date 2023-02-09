<div>
    <div>
        @section('title', __('Programación de vuelos'))
        <div class="p-6">
            <x-master.item label="Programación de vuelos" sublabel="Historial de vuelos">
                <x-slot name="avatar">
                    <i class="la la-list"></i>
                </x-slot>
            </x-master.item>
            @include('livewire.intranet.programacion-vuelo.vuelo.components.filter_datatable')
        </div>
    </div>
    {{-- <div class="mt-8 mb-4 text-xl font-semibold">
        Mostrando resultados de {{$this->fecha}}
    </div> --}}
    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>COD</th>
                        <th>Tipo vuelo</th>
                        <th>Matrícula Avión</th>
                        <th>Origen</th>
                        <th>Salida</th>
                        <th>Destino</th>
                        <th>Llegada</th>
                        <th>Tiempo de vuelo</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->codigo }}</td>
                            <td>
                                @include('livewire.intranet.components.badge-tipo-vuelo', [
                                    'tipo_vuelo' => $row->tipo_vuelo,
                                ])
                            </td>
                            <td>
                                @if (optional($row->avion)->matricula)
                                    {{ optional($row->avion)->matricula }}
                                @else
                                    <div class="badge badge-error badge-outline">Sin registrar</div>
                                @endif
                            </td>
                            <td>
                                <strong>
                                    {{ optional($row->origen)->codigo_default }}
                                </strong>
                                <p class="text-gray-500">
                                    {{ optional(optional($row->origen)->ubigeo)->distrito }}
                                </p>
                            </td>
                            <td>
                                {{ optional($row->fecha_hora_vuelo_programado)->format('Y-m-d') }} <br>
                                {{ optional($row->fecha_hora_vuelo_programado)->format('g:ia') }}
                            </td>
                            <td>
                                <strong>
                                    {{ optional($row->destino)->codigo_default }}
                                </strong>
                                <p class="text-gray-500">
                                    {{ optional(optional($row->destino)->ubigeo)->distrito }}
                                </p>
                            </td>
                            <td>
                                {{ optional($row->fecha_hora_aterrizaje_programado)->format('Y-m-d') }} <br>
                                {{ optional($row->fecha_hora_aterrizaje_programado)->format('g:ia') }}
                            </td>
                            <td>{{ $row->tiempo_vuelo }}</td>
                            <td>
                                @include('livewire.intranet.comercial.vuelo.components.vuelo-status', [
                                    'vuelo' => $row,
                                ])
                            </td>
                            <td class="w-3">
                                @can('intranet.programacion-vuelo.vuelo.show')
                                    <a href="{{ route('intranet.programacion-vuelo.vuelo.show', $row) }}"
                                        class="btn btn-circle btn-sm btn-success">
                                        <i class="la la-eye"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
