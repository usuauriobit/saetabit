<div>
    @section('title', __('Tasa de cambio'))
    <div class="cabecera p-6">
        <x-master.item label="Tasa de cambio" sublabel="Historial de valores diarios">
            <x-slot name="avatar">
                <i class="las la-paste"></i>
            </x-slot>
            @can('intranet.configuracion.tasa-cambio-valor.create')
                <x-slot name="actions">
                    <a class="btn btn-sm btn-primary" href="{{ route('intranet.configuracion.tasa-cambio-valor.create') }}">
                        <i class="la la-plus"></i> &nbsp; Registrar valor
                    </a>
                </x-slot>
            @endcan
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
                        <th>Valor venta</th>
                        <th>Registrado por</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->id }}</td>
                            <td>{{ optional($row->fecha)->format('Y-m-d') }}</td>
                            <td>@soles($row->valor_venta)</td>
                            <td>{{ optional($row->user_created)->email }}</td>
                            <td>
                                @if ($row->trashed())
                                    <div class="badge badge-error">Eliminado</div>
                                @else
                                    @if ($row->is_desactualizado)
                                        <div class="badge badge-warning">Desactualizado</div>
                                    @else
                                        <div class="badge badge-success">Actualizado</div>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @can('intranet.configuracion.tasa-cambio-valor.delete')
                                    @if (!$row->trashed())
                                        <button
                                            onclick="confirm('¿Está seguro de eliminar?')||event.stopImmediatePropagation()"
                                            class="btn btn-error btn-sm btn-outline"
                                            wire:click="delete({{ $row->id }})">
                                            <i class="la la-trash"></i>
                                        </button>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
