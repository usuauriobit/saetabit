<div>
    @section('title', __('Aperturas'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Aperturas - Cierres') }}" sublabel="Lista de Aperturas - Cierres">
            <x-slot name="actions">
                <div class="grid grid-cols-3 gap-4">
                    <x-master.select label="Oficina" name="oficina_id" wire:model="oficina_id" :options="$oficinas">
                    </x-master.select>
                    <x-master.input label="Desde" name="desde" wire:model="desde" type="date"></x-master.input>
                    <x-master.input label="Hasta" name="hasta" wire:model="hasta" type="date"></x-master.input>
                </div>
            </x-slot>
        </x-master.item>
    </div>

    <div class="card-white">
        <div class="card-body">
            <div wire:loading>
                @include('components.loader-horizontal-sm')
            </div>
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                    <div class="grid grid-cols-2 gap-4">
                        <x-master.select label="Tipo" name="tipo_caja_id" wire:model="tipo_caja_id" :options="$tipo_cajas"></x-master.select>
                        <x-master.select label="Cajero" name="cajero_id" wire:model="cajero_id" :options="$cajeros"
                            desc="nombre_completo"></x-master.select>
                    </div>
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Id</th>
                        <th>Oficina</th>
                        <th>Tipo</th>
                        <th>Caja</th>
                        <th>Fecha Apertura</th>
                        <th>Fecha Cierre</th>
                        <th>Cajero</th>
                        <th>Ingresos (S/.)</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->codigo }}</td>
                            <td>{{ $row->caja->oficina->descripcion }}</td>
                            <td>{{ $row->caja->tipo_caja->descripcion }}</td>
                            <td>{{ $row->caja->descripcion }}</td>
                            <td>{{ $row->fecha_apertura }}</td>
                            <td>{{ $row->fecha_cierre }}</td>
                            <td>{{ $row->user_created->name }}</td>
                            <td class="text-right">{{ number_format($row->total_recaudado, 2, '.', ',') }}</td>
                            <td class="text-center">
                                @can('intranet.caja.caja-apertura-cierre.show')
                                    <a href="{{ route('intranet.caja.caja-apertura-cierre.show', $row) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="la la-eye"></i>
                                    </a>
                                @endcan
                                @can('intranet.caja.caja-apertura-cierre.export')
                                    <a href="{{ route('intranet.caja.caja-apertura-cierre.export', $row) }}"
                                        class="mr-2 btn btn-warning btn-sm" target="_blank">
                                        <i class="la la-print"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
