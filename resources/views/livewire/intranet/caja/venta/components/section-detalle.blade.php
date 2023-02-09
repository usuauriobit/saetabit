<div class="col-span-5">
    <x-master.item label="ITEMS DE LA VENTA" class="my-4" sublabel="Lista de items">
        <x-slot name="actions">
        </x-slot>
    </x-master.item>
    <div class=" card-white">
        <div class="card-body">
            <x-master.datatable :items="$detalle">
                <x-slot name="thead">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Descripción</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Importe</th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach($detalle as $row)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $row->descripcion }}</td>
                            <td class="text-center">{{ $row->cantidad }}</td>
                            <td class="text-right">@soles($row->monto)</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="3">Total</td>
                        <td class="text-right">@soles($detalle->sum('monto'))</td>
                    </tr>
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
