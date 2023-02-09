<div class="col-span-5">
    <x-master.item label="MOVIMIENTOS EN CAJA" class="my-4" sublabel="Lista de Movimientos">
        @if (!$venta->is_pagado)
            <x-slot name="actions">
                @can('intranet.caja.caja-movimiento.create')
                    <a href="#createMovimientoModal" class="btn btn-primary btn-sm">
                        <i class="la la-plus"></i> Agregar
                    </a>
                @endcan
            </x-slot>
        @endif
    </x-master.item>
    <div class=" card-white">
        <div class="card-body">
            <x-master.datatable :items="$movimientos">
                <x-slot name="thead">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Tipo Pago</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Importe</th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach($movimientos as $row)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ optional($row->tipo_pago ?? null)->descripcion }}</td>
                            <td class="text-center">{{ $row->fecha->format('d-m-Y') }}</td>
                            <td class="text-right">@soles($row->total)</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="3">Total</td>
                        <td class="text-right">@soles($movimientos->sum('total'))</td>
                    </tr>
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
