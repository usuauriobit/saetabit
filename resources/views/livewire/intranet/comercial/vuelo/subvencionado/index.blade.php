<div>
    @section('title', __('Vuelos charter - comercial'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Vuelos subvencionados') }}" sublabel="Lista de Vuelos subvencionados">
            {{-- <x-slot name="actions">
                <a href="{{ route('intranet.comercial.vuelo_charter.comercial.create') }}" class="btn btn-primary"> <i
                        class="la la-plus"></i> &nbsp; Registrar vuelo</a>
            </x-slot> --}}
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
                        <th>Nro contrato</th>
                        <th width="50px">Cliente</th>
                        <th>Paquete</th>
                        <th>Importe</th>
                        <th>Ruta</th>
                        <th>Fecha de inicio <br> (Según filtro)</th>
                        <th>Fecha final <br> (Según filtro)</th>
                        <th># Vuelos</th>
                        {{-- <th>Estado</th> --}}
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->nro_contrato }}</td>
                            <td width="50px">{{ optional($row->cliente)->razon_social }}</td>
                            <td>{{ $row->paquete }}</td>
                            <td>{{ $row->monto_total }}</td>
                            <td>
                                <i class="las la-plane-departure"></i>
                                {{ optional(optional(optional($row->ruta)->tramo)->origen)->descripcion }}
                                <br>
                                <i class="las la-plane-arrival"></i>
                                {{ optional(optional(optional($row->ruta)->tramo)->destino)->descripcion }}
                            </td>
                            <td>{{ optional($row->fecha_inicio)->format('Y-m-d') }}</td>
                            <td>{{ optional($row->fecha_final)->format('Y-m-d') }}</td>
                            <td>{{ optional($row->vuelos)->count() }}</td>
                            {{-- <td>
                                @include('livewire.intranet.comercial.vuelo.components.vuelo-status', ['vuelo' => $row])
                            </td> --}}
                            <td class="w-3">
                                {{-- <a href="{{ route('intranet.comercial.vuelo.show', $row->id) }}"
                                    class="btn btn-circle btn-sm btn-success">
                                    <i class="la la-eye"></i>
                                </a> --}}
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
