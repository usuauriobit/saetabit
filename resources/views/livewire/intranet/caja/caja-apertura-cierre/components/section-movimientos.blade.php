<div class="col-span-5">
    <x-master.item label="Movimientos" class="my-4" sublabel="Lista de Movimientos">
            <x-slot name="actions">
                {{-- <a href="#createVentaDetalleModal" wire:click="createVentaDetalle" class="btn btn-primary btn-sm"> <i class="la la-plus"></i>
                    Agregar
                </a> --}}
            </x-slot>
    </x-master.item>
    <div class=" card-white">
        <div class="card-body">
            <x-master.datatable :items="$movimientos" :wire:key="now() . '_movimientos'">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Tipo</th>
                        <th>Doc Serie</th>
                        <th>Num</th>
                        <th>Fecha</th>
                        <th>Descripcion</th>
                        <th>Cliente</th>
                        <th>Ruta</th>
                        <th>Importe</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($movimientos as $movimiento)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $movimiento->tipo_pago->descripcion }}</td>
                        <td>{{ $movimiento->serie_correlativo }}</td>
                        <td> {{ $movimiento->codigo }} </td>
                        <td> {{ $movimiento->fecha->format('d-m-Y') }} </td>
                        <td> {{ $movimiento->documentable->descripcion }} </td>
                        <td> {{ $movimiento->documentable->clientable->nombre_completo }} </td>
                        <td> {{ '-' }} </td>
                        <td> {{ $movimiento->monto }} </td>
                        <td>
                            <div class="badge badge-success">Pagado</div>
                        </td>
                        <td class="w-3">
                            <form action="{{ route('intranet.caja.venta.show', $movimiento->documentable_id) }}" method="get">
                                <input type="text" name="caja_apertura_id" value="{{ $movimiento->documentable->caja_movimiento[0]->apertura_cierre_id }}" hidden>
                                <button class="btn btn-circle btn-sm btn-success">
                                    <i class="la la-eye"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
