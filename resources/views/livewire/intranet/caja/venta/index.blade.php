<div>
    @section('title', __('Ventas'))
    <div class="cabecera p-6">
        <x-master.item labelSize="xl" label="{{ ucfirst('Ventas') }}" sublabel="Lista de Ventas">
            <x-slot name="actions">
                <div class="grid grid-cols-5 gap-4">
                    <x-master.input label="N° Venta" name="n_venta" wire:model.debounce.700ms="n_venta"></x-master.input>
                    <x-master.input label="Serie" name="serie" wire:model.debounce.700ms="serie" placeholder="B001"></x-master.input>
                    <x-master.input label="Correlativo" name="correlativo" wire:model.debounce.700ms="correlativo" placeholder="000558"></x-master.input>
                    <x-master.input label="Desde" name="desde" wire:model="desde" type="date"></x-master.input>
                    <x-master.input label="Hasta" name="hasta" wire:model="hasta" type="date"></x-master.input>
                </div>
            </x-slot>
        </x-master.item>
    </div>

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                    <div class="grid grid-cols-2 gap-4">
                        <x-master.input label="Doc Cliente" name="nro_documento" wire:model.debounce.700ms="nro_documento" placeholder="Buscar..."></x-master.input>
                        <x-master.input label="Nombre Cliente" name="search" wire:model.debounce.700ms="search" placeholder="Buscar..."></x-master.input>
                    </div>
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>N° Venta</th>
                        <th>Serie</th>
                        <th>Correlativo</th>
                        <th>N° Doc.</th>
                        <th>Cliente</th>
                        <th>Importe (S/.)</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->codigo }}</td>
                            <td>{{ optional($row->comprobante ?? null)->serie ?? '-' }}</td>
                            <td>{{ optional($row->comprobante ?? null)->correlativo ?? '-' }}</td>
                            <td>{{ optional($row->clientable ?? null)->documento ?? '-' }}</td>
                            <td>{{ optional($row->clientable ?? null)->nombre_short ?? '-' }}</td>
                            <td>{{ number_format($row->importe, 2, '.', ',') }}</td>
                            <td>{{ optional($row->created_at ?? null)->format('Y-m-d') }}</td>
                            <td class="text-center">
                                @if ($row->trashed())
                                    <div class="badge badge-error">ANULADO</div>
                                @else
                                    <a href="{{ route('intranet.caja.venta.show', [
                                        'venta' => $row->id,
                                        'caja_apertura_id' => $row->caja_movimiento[0]->apertura_cierre_id,
                                        'caja_id' => $row->caja_movimiento[0]->caja_id,
                                    ]) }}"
                                        class="btn btn-circle btn-sm btn-primary">
                                        <i class="la la-eye"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
