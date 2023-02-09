<div class="col-span-5">
    <x-master.item label="Denominaciones" class="my-4" sublabel="Lista de Denominaciones">
            <x-slot name="actions">
                {{-- <a href="#createVentaDetalleModal" wire:click="createVentaDetalle" class="btn btn-primary btn-sm"> <i class="la la-plus"></i>
                    Agregar
                </a> --}}
                {{-- <x-master.item class="mb-4" label="Total (S/.)" :sublabel="number_format($apertura_cierre->total_billetes, 2, '.', ',')"></x-master.item> --}}
            </x-slot>
    </x-master.item>
    <div class=" card-white">
        <div class="card-body">
            <x-master.datatable :items="$denominaciones" :wire:key="now() . '_denominaciones'">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Importe</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($denominaciones as $billete)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $billete->denominacion->denominacion }}</td>
                            <td>{{ $billete->cantidad }}</td>
                            <td class="text-right">{{ number_format($billete->total, 2, '.', ',') }}</td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
