<x-master.datatable :items="$items" compact="table-compact">
    <x-slot name="thead">
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Tipo</th>
            <th class="text-center">Doc Serie</th>
            <th class="text-center">Num</th>
            <th class="text-center">Fecha</th>
            <th class="text-center">Descripcion</th>
            <th class="text-center">Cliente</th>
            <th class="text-center">Ruta</th>
            <th class="text-center">Tipo Pago</th>
            <th class="text-center">Importe</th>
            <th class="text-center">Estado</th>
            <th></th>
        </tr>
    </x-slot>
    <x-slot name="tbody">
        @foreach($items as $row)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $row->tipo_servicio }}</td>
                <td class="text-center">
                    {{ optional(optional($row->documentable ?? null)->comprobante ?? null)->serie_correlativo ?? '-' }}
                </td>
                <td class="text-center"> {{ $row->codigo }} </td>
                <td class="text-center"> {{ $row->fecha->format('d-m-Y') }} </td>
                <td style="max-width: 80px;">
                    <div class="grid grid-cols-2 gap-4">
                        <p class="truncate">{{ $row->documentable->descripcion }}</p>
                        <x-tooltip>{{ $row->documentable->descripcion }}</x-tooltip>
                    </div>
                </td>
                <td> {{ $row->documentable->clientable->nombre_short }} </td>
                <td> {{ '-' }} </td>
                <td class="text-center"> {{ $row->tipo_pago->descripcion }} </td>
                <td class="text-right">
                    @soles($row->total)
                </td>
                <td class="text-center">
                    @include('livewire.intranet.caja.caja.components.estadoMovimientos')
                </td>
                <td class="text-center">
                    @include('livewire.intranet.caja.caja.components.actionsMovimientos')
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-master.datatable>
