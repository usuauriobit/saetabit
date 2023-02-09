<div>
    @section('title', __('Historial de registro de vuelos'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Historial de registro de vuelos') }}" sublabel="Lista de vuelos agrupados">
            {{-- <x-slot name="actions">
                <a href="{{ route('intranet.comercial.vuelo_charter.comercial.create') }}" class="btn btn-primary"> <i
                        class="la la-plus"></i> &nbsp; Registrar vuelo</a>
            </x-slot> --}}
        </x-master.item>
        @include('livewire.intranet.programacion-vuelo.vuelo.components.filter_datatable')
    </div>
    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Tipo</th>
                        <th>Ruta</th>
                        <th>Fecha de inicio <br> (Según filtro)</th>
                        <th>Fecha final</th>
                        <th># Vuelos <br> generados</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->tipo_vuelo->descripcion }}</td>
                            <td>
                                <div class="overflow-hidden text-ellipsis">
                                    <i class="las la-plane-departure"></i>
                                    {{ optional(optional(optional($row->ruta)->tramo)->origen)->codigo_default }}
                                    <br>
                                    <i class="las la-plane-arrival"></i>
                                    {{ optional(optional(optional($row->ruta)->tramo)->destino)->codigo_default }}
                                </div>
                            </td>
                            <td>{{ optional($row->fecha_inicio)->format('Y-m-d') }}</td>
                            <td>{{ optional($row->fecha_final)->format('Y-m-d') }}</td>
                            <td>{{ optional($row->vuelos)->count() }}</td>
                            {{-- <td>
                                @include('livewire.intranet.comercial.vuelo.components.vuelo-status', ['vuelo' => $row])
                            </td> --}}
                            <td class="w-3">
                                <a href="{{ route('intranet.programacion-vuelo.vuelo-massive.show', $row->id) }}"
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
