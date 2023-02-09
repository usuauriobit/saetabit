<div>
    @section('title', __('Vuelos charter - comercial'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Vuelos charter - comercial') }}" sublabel="Lista de Vuelos charter - comercial">
            <x-slot name="actions">
                <a href="{{ route('intranet.comercial.vuelo_charter.comercial.create') }}" class="btn btn-primary"> <i
                        class="la la-plus"></i> &nbsp; Registrar vuelo</a>
            </x-slot>
        </x-master.item>
    </div>
    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Avión</th>
                        {{-- <th>Piloto</th> --}}
                        <th>Ruta</th>
                        <th>Fecha de vuelo <br> (programado)</th>
                        <th>Fecha de aterrizaje <br> (programado)</th>
                        <th>Usuario (Creador)</th>
                        <th># pasajeros</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($row->avion)->matricula }}</td>
                            {{-- <td>{{ optional($row->piloto)->descripcion }}</td> --}}
                            <td>
                                <i class="las la-plane-departure"></i>
                                {{ optional($row->origen)->descripcion }}
                                <br>
                                <i class="las la-plane-arrival"></i>
                                {{ optional($row->destino)->descripcion }}
                            </td>
                            <td>{{ optional($row->fecha_hora_vuelo_programado)->format('Y-m-d') }}</td>
                            <td>{{ optional($row->fecha_hora_aterrizaje_programado)->format('Y-m-d') }}</td>
                            <td>
                                <span class="text-sm">
                                    {{ optional($row->user_created)->name }}
                                </span>
                            </td>
                            <td>{{ optional($row->pasajeros)->count() }}</td>
                            <td>
                                @include('livewire.intranet.comercial.vuelo.components.vuelo-status', [
                                    'vuelo' => $row,
                                ])
                            </td>
                            <td class="w-3">
                                <a href="{{ route('intranet.comercial.vuelo.show', $row->id) }}"
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
