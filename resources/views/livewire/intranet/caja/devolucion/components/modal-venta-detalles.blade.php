<x-master.modal id-modal="ventaDetalleModal" label="Selecciona un detalle venta para realizar la devolución" wSize="6xl">
    <x-master.datatable :items="$detalles_ventas">
        <x-slot name="actions">
            <div class="grid grid-cols-4 gap-4">
                <x-master.input label="Desde" name="desde_dv" wire:model="desde_dv" type="date"></x-master.input>
                <x-master.input label="Hasta" name="hasta_dv" wire:model="hasta_dv" type="date"></x-master.input>
                <x-master.input label="N° Doc" name="nro_doc_dv" wire:model.debounce.700ms="nro_doc_dv"></x-master.input>
                <x-master.input label="Cliente" name="cliente_dv" wire:model.debounce.700ms="cliente_dv"></x-master.input>
            </div>
        </x-slot>
        <x-slot name="thead">
            <tr>
                <th>#</th>
                <th>Tipo</th>
                <th>N° Venta</th>
                <th>Comprobante</th>
                <th>N° Doc</th>
                <th>Cliente</th>
                <th>Descripción</th>
                <th>Importe</th>
                <th>Fecha</th>
                <th></th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach ($detalles_ventas as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->tipo_servicio }}</td>
                    <td>{{ $row->venta->codigo }}</td>
                    <td>{{ $row->venta->correlativo_completo }}</td>
                    <td>{{ optional($row->venta ?? null)->nro_documento ?? '-' }}</td>
                    <td>{{ optional($row->venta->clientable ?? null)->nombre_short ?? '-' }}</td>
                    <td>{{ $row->descripcion }}</td>
                    <td>@soles($row->importe)</td>
                    <td>{{ optional($row->venta->created_at ?? null)->format('Y-m-d') }}</td>
                    <td class="text-center">
                        @if ($row->can_devolucion)
                            <button wire:click="addVentaDetalle({{$row->id}})" class="mr-2 btn btn-success btn-sm">
                                <i class="la la-check"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-master.datatable>
</x-master.modal>
