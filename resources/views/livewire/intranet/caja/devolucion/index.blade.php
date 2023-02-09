<div>
    @section('title', __('Devoluciones'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Devoluciones') }}" sublabel="Lista de Devoluciones">
            <x-slot name="actions">
                @can('intranet.caja.devolucion.create')
                    <a href="#ventaDetalleModal" class="btn btn-primary btn-sm"> <i class="la la-plus"></i> Nueva Devolución</a>
                @endcan
            </x-slot>
        </x-master.item>
    </div>
    @include('livewire.intranet.caja.devolucion.components.modal-venta-detalles')

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                    <div class="grid grid-cols-5 gap-4">
                        <x-master.select label="Estado" name="status" wire:model="status" :options="$status_devolucion" />
                        <x-master.input label="Desde" name="desde" wire:model="desde" type="date"></x-master.input>
                        <x-master.input label="Hasta" name="hasta" wire:model="hasta" type="date"></x-master.input>
                        <x-master.input label="N° Doc" name="nro_doc_devolucion" wire:model.debounce.700ms="nro_doc_devolucion"></x-master.input>
                        <x-master.input label="Cliente" name="cliente_devolucion" wire:model.debounce.700ms="cliente_devolucion"></x-master.input>
                    </div>
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">N° Venta</th>
                        <th class="text-center">N° Comp.</th>
                        <th class="text-center">N° Devolución</th>
                        <th class="text-center">N° Doc Cliente</th>
                        <th class="text-center">Cliente</th>
                        <th class="text-center">Importe Devuelto (S/.)</th>
                        <th class="text-center">Registrado por</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Revisado por</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ optional($row->placelable->venta->created_at ?? null)->format('Y-m-d') }}</td>
                            <td class="text-center">{{ optional($row->placelable->venta)->codigo ?? '-' }}</td>
                            <td class="text-center">{{ optional(optional($row->placelable->venta ?? null)->comprobante ?? null)->serie_correlativo ?? '-' }}</td>
                            <td class="text-center">{{ $row->codigo ?? '-' }}</td>
                            <td class="text-center">{{ $row->placelable->venta->nro_documento }}</td>
                            <td>{{ $row->placelable->venta->descripcion_cliente }}</td>
                            <td class="text-right">@soles($row->importe_devolucion)</td>
                            <td class="text-left">{{ $row->user_created->name }}</td>
                            <td class="text-center">
                                <div class="badge badge-{{ $row->color_status }}">{{ $row->status_reviewed }}</div>
                            </td>
                            <td class="text-left">{{ optional($row->reviewed_by ?? null)->name ?? null }}</td>
                            <td class="text-center">
                                <a href="{{ route('intranet.caja.devolucion.show', $row) }}" class="btn btn-success btn-circle btn-sm">
                                    <i class="la la-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
