<div class="col-span-5">
    <x-master.item label="Resumen de Cierre de Caja" class="my-4" sublabel="">
            <x-slot name="actions">
                {{-- <a href="#createVentaDetalleModal" wire:click="createVentaDetalle" class="btn btn-primary btn-sm"> <i class="la la-plus"></i>
                    Agregar
                </a> --}}
                {{-- <x-master.item class="mb-4" label="Total (S/.)" :sublabel="number_format($apertura_cierre->total_billetes, 2, '.', ',')"></x-master.item> --}}
            </x-slot>
    </x-master.item>
    <div class=" card-white">
        <div class="card-body">
            <table class="table table-bodered">
                <thead>
                    <tr>
                        <th class="text-center">Forma de Pago</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Efectivo</td>
                        <td class="text-right">
                            <div class="text-xl">@soles($apertura_cierre->total_efectivo)</div>
                        </td>
                    </tr>
                    @foreach ($tarjetas as $tarjeta)
                        <tr>
                            <td>{{ $tarjeta->descripcion }}</td>
                            <td class="text-right">
                                <div class="text-xl">@soles($apertura_cierre->getMovimientosTarjetaAttribute($tarjeta->id)->sum('total'))</div>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>Depósitos en cuenta</td>
                        <td class="text-right">
                            <div class="text-xl">@soles($apertura_cierre->total_depositos)</div>
                        </td>
                    </tr>
                    <tr>
                        <td>Créditos</td>
                        <td class="text-right">
                            <div class="text-xl">@soles($apertura_cierre->total_creditos)</div>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-center">TOTAL RECAUDADO</th>
                        <th class="text-right">
                            <div class="text-2xl">@soles($apertura_cierre->total_recaudado)</div>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
