<div>
    <div>
        @section('title', __('Vuelos'))
        <livewire:calendar-horizontal ></livewire:calendar-horizontal>
    </div>
    <div class="mt-8 mb-4 text-xl font-semibold">
        Mostrando resultados de {{$this->fecha}}
    </div>
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
                    @foreach($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->codigo }}</td>
                            <td>
                                @if (!$row->tipo_vuelo->is_desc_same_as_category)
                                    <span class="text-sm font-bold text-gray-400">
                                        {{ optional(optional($row->tipo_vuelo)->categoria_vuelo)->descripcion }}
                                    </span>
                                    <br>
                                @endif
                                {{ optional($row->tipo_vuelo)->descripcion }}
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
                                {{ optional($row->fecha_hora_vuelo_programado)->format('H:i') }}
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
                                {{ optional($row->fecha_hora_aterrizaje_programado)->format('H:i') }}
                            </td>
                            <td>{{ $row->tiempo_vuelo }}</td>
                            <td>
                                @include('livewire.intranet.comercial.vuelo.components.vuelo-status', ['vuelo' => $row])
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
