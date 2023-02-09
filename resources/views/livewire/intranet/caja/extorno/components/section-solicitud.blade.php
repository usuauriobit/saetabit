<div class="col-span-5">
    <x-master.item label="Solicitudes" class="my-4" sublabel="Lista de Solicitudes de Extornos">
        <x-slot name="actions">
            {{-- <a href="#createVentaDetalleModal" wire:click="createVentaDetalle" class="btn btn-primary btn-sm"> <i class="la la-plus"></i>
                Agregar
            </a> --}}
        </x-slot>
    </x-master.item>
    <div class=" card-white">
        <div class="card-body">
            <x-master.datatable :items="$solicitudes">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>N° Movimiento</th>
                        <th>Caja</th>
                        <th>Oficina</th>
                        <th>Solicitado por</th>
                        <th>Motivo</th>
                        <th>Importe</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach($solicitudes as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->codigo }}</td>
                            <td>{{ $row->caja->descripcion }}</td>
                            <td>{{ $row->caja->oficina->descripcion }}</td>
                            <td>{{ $row->solicitud_extorno_por->name }}</td>
                            <td>{{ $row->motivo_extorno }}</td>
                            <td class="text-right">{{ number_format($row->total, 2, '.', ',') }}</td>
                            <td class="w-3">
                                @can('intranet.caja.extorno.aprobar')
                                    <button wire:click="extornarMovimiento({{ $row->id }})" class="btn btn-circle btn-sm btn-success"
                                        onclick="confirm('¿Está seguro de extornar? No podrá recuperarlo después')||event.stopImmediatePropagation()">
                                        <i class="la la-check"></i>
                                    </button>
                                @endcan
                                @can('intranet.caja.extorno.rechazar')
                                    <button wire:click="rechazarExtorno({{ $row->id }})" class="btn btn-circle btn-sm btn-error"
                                        onclick="confirm('¿Estás seguro de recahazar el extorno?')||event.stopImmediatePropagation()">
                                        <i class="la la-close"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
