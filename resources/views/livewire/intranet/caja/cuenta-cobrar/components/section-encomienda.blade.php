<div class="col-span-5">
    <x-master.item label="Detalle" class="my-4" sublabel="Lista de Encomiendas">
        <x-slot name="actions">

        </x-slot>
    </x-master.item>
    <div class=" card-white">
        <div class="card-body">
            <x-master.datatable :items="$encomiendas">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Remitente</th>
                        <th>Consignatario</th>
                        <th>Fecha</th>
                        <th>Importe</th>
                        <th>Saldo</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach($encomiendas as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->codigo }}</td>
                            <td>{{ $row->remitente->nombre_short }}</td>
                            <td>{{ $row->consignatario->nombre_short }}</td>
                            <td>{{ $row->fecha->format('Y-m-d') }}</td>
                            <td class="text-right">
                                @dolares($row->importe_total) <br>
                                @soles($row->importe_total_soles)
                            </td>
                            <td class="text-right">@soles($row->monto_pago_pendiente)</td>
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
