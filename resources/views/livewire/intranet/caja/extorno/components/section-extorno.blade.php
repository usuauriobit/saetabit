<div class="col-span-5">
    <x-master.item label="Extornos" class="my-4" sublabel="Lista de Movimientos Extornados">
        <x-slot name="actions">
        </x-slot>
    </x-master.item>
    <div class=" card-white">
        <div class="card-body">
            <x-master.datatable :items="$extornos">
                <x-slot name="actions">
                    <div class="grid grid-cols-2 gap-4">
                        <x-master.input label="Desde" name="desde" wire:model="desde" type="date"></x-master.input>
                        <x-master.input label="Hasta" name="hasta" wire:model="hasta" type="date"></x-master.input>
                    </div>
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>N° Movimiento</th>
                        <th>Caja</th>
                        <th>Oficina</th>
                        <th>Solicitado por</th>
                        <th>Solicitado el</th>
                        <th>Aprobador por</th>
                        <th>Importe</th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach($extornos as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->codigo }}</td>
                            <td>{{ $row->caja->descripcion }}</td>
                            <td>{{ $row->caja->oficina->descripcion }}</td>
                            <td>{{ $row->solicitud_extorno_por->name }}</td>
                            <td>{{ $row->solicitud_extorno_date->format('d-m-Y H:i:s') }}</td>
                            <td>{{ $row->solicitud_extorno_aprovado_por->name }}</td>
                            <td class="text-right">{{ number_format($row->total, 2, '.', ',') }}</td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
