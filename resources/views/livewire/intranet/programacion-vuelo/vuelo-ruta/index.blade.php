<div>
    <div>
        @section('title', __('Vuelos en rutas'))
    </div>
    <div class="cabecera p-6">
        <x-master.item label="Vuelos por ruta" sublabel="Vuelos agrupados según su ruta">
            <x-slot name="actions">
            </x-slot>
        </x-master.item>
        {{-- @include('livewire.intranet.programacion-vuelo.vuelo-ruta.components.filter_datatatable') --}}

        @include('livewire.intranet.programacion-vuelo.vuelo.components.filter_datatable')
    </div>
    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Tipo vuelo</th>
                        <th>Primer vuelo</th>
                        <th>Último vuelo</th>
                        <th># vuelos</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @include('livewire.intranet.components.badge-tipo-vuelo', [
                                    'tipo_vuelo' => $row->tipo_vuelo,
                                ])
                            </td>
                            <td>
                                <x-item.ubicacion onlyDistrito :ubicacion="optional($row->vuelo_inicial)->origen"></x-item.ubicacion>
                                <x-master.item label="Fecha de despegue" :sublabel="optional(optional($row->vuelo_inicial)->fecha_hora_vuelo_programado)->format(
                                    'Y-m-d g:i a',
                                )"></x-master.item>
                            </td>
                            <td>
                                <x-item.ubicacion onlyDistrito :ubicacion="optional($row->vuelo_final)->destino"></x-item.ubicacion>
                                <x-master.item label="Fecha de aterrizaje" :sublabel="optional(
                                    optional($row->vuelo_final)->fecha_hora_aterrizaje_programado,
                                )->format('Y-m-d g:i a')"></x-master.item>
                            </td>
                            <td>
                                <div class="badge badge-primary">{{ $row->vuelos->count() }}</div>
                            </td>
                            <td>
                            </td>
                            <td class="w-3">
                                <a href="{{ route('intranet.programacion-vuelo.vuelo-ruta.show', $row) }}"
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
