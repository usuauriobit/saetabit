<div class="col-span-5">
    <x-master.item label="Detalle" class="my-4" sublabel="Lista de encomiendas">
        @if ($guia_despacho->can_manipulate)
            <x-slot name="actions">
                <a href="#createGuiaDespachoDetalleModal" wire:click="createDetalle" class="btn btn-primary"> <i
                        class="la la-plus"></i>
                    Agregar</a>
            </x-slot>
        @endif
    </x-master.item>
    <div class="overflow-x-auto card-white">
        <table class="table w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tipo</th>
                    <th>Cant</th>
                    <th>Descripción</th>
                    <th>Peso (Kg)</th>
                    <th>Dimensiones</th>
                    <th>Importe</th>
                    <th>Monto valorizado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detalle as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($row->is_sobre)
                                <div class="badge badge-info">Sobre</div>
                            @else
                                <div class="badge badge-success">Paquete</div>
                            @endif
                        </td>
                        <td>{{ $row->cantidad }}</td>
                        <td>{{ $row->descripcion }}</td>
                        <td>{{ $row->peso }}</td>
                        <td>
                            @if (!$row->is_sobre)
                                {{ $row->largo }} cm x <br>
                                {{ $row->ancho }} cm x <br>
                                {{ $row->alto }} cm
                            @endif
                        </td>
                        <td>
                            @can('intranet.tracking-carga.guia-despacho.show-importe')
                                <strong>@soles($row->importe)</strong>
                            @endcan
                            {{-- ≈ @soles($row->importe_soles) --}}
                        </td>
                        <td>
                            {{ $row->monto_valorado }}
                        </td>
                        <td class="w-3">
                            @if ($guia_despacho->can_manipulate)
                                <a href="#createGuiaDespachoDetalleModal" wire:click="editDetalle({{ $row->id }})"
                                    class="btn btn-circle btn-sm btn-warning">
                                    <i class="la la-edit"></i>
                                </a>
                                <button wire:click="destroyDetalle({{ $row->id }})"
                                    class="btn btn-circle btn-sm btn-danger"
                                    onclick="confirm('¿Está seguro de eliminar? No podrá recuperarlo después')||event.stopImmediatePropagation()">
                                    <i class="la la-trash"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
