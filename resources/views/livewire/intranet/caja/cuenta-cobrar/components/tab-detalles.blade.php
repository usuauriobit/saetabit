<div class="cabecera p-6">
    <x-master.item label="Detalle de la Cuenta" sublabel="Items">
        <x-slot name="avatar">
            <i class="la la-list"></i>
        </x-slot>
        <x-slot name="actions">
            @if (!$cuenta_cobrar->comprobante)
                @can('intranet.caja.cuenta-cobrar.detalle.create')
                    <a class="btn btn-success btn-sm" href="#addDetalleModal">
                        <i class="la la-add"></i>
                        Agregar detalle
                    </a>
                @endcan
            @endif
        </x-slot>
    </x-master.item>
</div>
<div class="card-white">
    <div class="mt-2 overflow-x-auto">
        <table class="table w-full">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Concepto</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">P.U. (S/.)</th>
                    <th class="text-center">Total (S/.) </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cuenta_cobrar->detalles as $detalle)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detalle->concepto }}</td>
                        <td class="text-right">{{ $detalle->cantidad }}</td>
                        <td class="text-right">@soles($detalle->precio_unitario)</td>
                        <td class="text-right">@soles($detalle->importe)</td>
                        <td class="text-center">
                            @if ($detalle->disponible_eliminar)
                                @can('intranet.caja.cuenta-cobrar.detalle.delete')
                                    <button class="btn btn-circle btn-sm btn-error" wire:click="deleteDetalle({{ $detalle->id }})"
                                        onclick="confirm('¿Está seguro de eliminar?')||event.stopImmediatePropagation()">
                                        <i class="la la-trash"></i>
                                    </button>
                                @endcan
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
