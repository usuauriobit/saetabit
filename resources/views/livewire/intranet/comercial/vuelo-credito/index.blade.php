<div>
    @section('title', __('Programación de vuelos'))
    <div class="cabecera p-6">
        <x-master.item label="Créditos de vuelos" sublabel="Historial de créditos de vuelos">
            <x-slot name="avatar">
                <i class="las la-paste"></i>
            </x-slot>
        </x-master.item>
    </div>
    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Tipo vuelo</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Fecha de último pago</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->id }}</td>
                            <td>
                                {{ optional($row->created_at)->format('Y-m-d') }} <br>
                                {{ optional($row->created_at)->format('g:i a') }}
                            </td>
                            <td>
                                <small>{{ optional($row->clientable)->nombre_completo }}</small> <br>
                                <strong>{{ optional($row->clientable)->nro_doc }}</strong>
                            </td>
                            <td>
                                @includeWhen(optional($row->vuelo_ruta)->tipo_vuelo,
                                    'livewire.intranet.components.badge-tipo-vuelo',
                                    ['tipo_vuelo' => $row->vuelo_ruta->tipo_vuelo])
                            </td>
                            <td>
                                <x-item.ubicacion onlyDistrito :ubicacion="optional($row->vuelo_ruta)->origen" />
                            </td>
                            <td>
                                <x-item.ubicacion onlyDistrito :ubicacion="optional($row->vuelo_ruta)->destino" />
                            </td>
                            <td>
                                {{ optional($row->ultima_amortizacion_fecha)->format('Y-m-d') }}
                                {{-- <br>
                                {{ optional($row->ultima_amortizacion_fecha)->format('g:i a') }} --}}
                            </td>
                            <td>
                                @include('livewire.intranet.comercial.vuelo-credito.components.status', [
                                    'vuelo_credito' => $row,
                                ])
                            </td>
                            <td>
                                @can('intranet.comercial.vuelo-credito.show')
                                    <a href="{{ route('intranet.comercial.vuelo-credito.show', $row) }}"
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
