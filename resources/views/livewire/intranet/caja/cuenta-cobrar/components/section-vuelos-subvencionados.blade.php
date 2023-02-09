<div class="col-span-5">
    <x-master.item label="Detalle" class="my-4" sublabel="Lista de Paquetes">
        <x-slot name="actions">

        </x-slot>
    </x-master.item>
    <div class=" card-white">
        <div class="card-body">
            <x-master.datatable :items="$vuelos_subvencionados">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Paquete</th>
                        <th>N° Contrato</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Importe</th>
                        <th>Saldo</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach($vuelos_subvencionados as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->paquete }}</td>
                            <td>{{ $row->nro_contrato }}</td>
                            <td>{{ $row->cliente->nombre_completo }}</td>
                            <td>{{ $row->created_at->format('Y-m-d') }}</td>
                            <td class="text-right">{{ number_format($row->monto_total, 2, '.', ',') }}</td>
                            <td class="text-right">{{ number_format($row->monto_pago_pendiente, 2, '.', ',') }}</td>
                            <td>
                                @if ($row->is_pagado)
                                    <div class="badge badge-success">¡Cancelado!</div>
                                @else
                                    <div class="badge badge-warning">¡Pendiente!</div>
                                @endif
                            </td>
                            <td class="w-3">
                                <a href="{{ route('intranet.caja.cuenta-cobrar.show', [
                                    'model_id' => $row,
                                    'class' => get_class($row)
                                ]) }}" class="btn btn-primary btn-circle btn-sm">
                                    <i class="la la-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    {{-- <tr>
                        <td class="text-center" colspan="3">Total</td>
                        <td class="text-right">{{ number_format($detalle->sum('monto'), 2, '.', ',') }}</td>
                    </tr> --}}
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
