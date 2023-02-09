<div>
    @section('title', __('Comprobantes'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Comprobantes') }}" sublabel="Lista de Comprobantes">
            <x-slot name="actions">
                <div class="flex items-end gap-4">
                    <a href="#createNotaCreditoModal" class="btn btn-primary btn-sm">
                        <i class="la la-plus"></i> Emitir N.C.
                    </a>
                </div>
            </x-slot>
        </x-master.item>
    </div>
    @include('livewire.intranet.caja.comprobante.components.modal-comprobantes')
    @include('livewire.intranet.caja.comprobante.components.modal-error')
    @include('livewire.intranet.caja.comprobante.components.modal-motivo-anulacion')

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                    <div class="grid grid-cols-5 gap-4">
                        <x-master.select label="Caja" name="caja" wire:model="caja" :options="$cajas"></x-master.select>
                        <x-master.input label="Serie" name="serie" wire:model.debounce.700ms="serie" placeholder="B001"></x-master.input>
                        <x-master.input label="Correlativo" name="correlativo" wire:model.debounce.700ms="correlativo" placeholder="000558"></x-master.input>
                        <x-master.input label="Desde" name="desde" wire:model="desde" type="date"></x-master.input>
                        <x-master.input label="Hasta" name="hasta" wire:model="hasta" type="date"></x-master.input>
                        {{-- <x-master.input placeholder="Buscar..." name="search" wire:model="search"></x-master.input> --}}
                    </div>
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Fecha Emisión</th>
                        <th>N° Venta</th>
                        <th>Tipo</th>
                        <th>Correlativo</th>
                        <th>N° Doc.</th>
                        <th>Razón Social</th>
                        <th>Importe (S/.)</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($row->fecha_emision ?? null)->format('d-m-Y') }}</td>
                            <td>{{ optional($row->documentable ?? null)->codigo ?? '-' }}</td>
                            <td>{{ $row->tipo_comprobante->descripcion }}</td>
                            <td>{{ $row->serie_correlativo }}</td>
                            <td>{{ $row->nro_documento }}</td>
                            <td>{{ $row->denominacion }}</td>
                            <td>{{ number_format($row->total_importe, 2, '.', ',') }}</td>
                            <td class="text-center">
                                @isset($row->ultima_respuesta)
                                    @if ($row->trashed())
                                        <div class="badge badge-error">Anulado</div>
                                    @else
                                        @if ($row->ultima_respuesta->enlace_del_pdf == null)
                                            <div class="badge badge-warning">¡Error!</div>
                                            <a href="#showErrorModal" wire:click="showError({{ $row->id }})"
                                                class="">
                                                <i class="la la-info"></i>
                                            </a>
                                        @else
                                            <div class="badge badge-success">Facturado</div>
                                        @endif
                                    @endif
                                @endisset
                            </td>
                            <td class="text-center">
                                <a href="{{ optional($row->ultima_respuesta ?? null)->enlace_del_pdf }}"
                                    class="btn btn-success btn-circle btn-sm" target="_blank">
                                    <i class="la la-eye"></i>
                                </a>
                                @can('intranet.caja.comprobante.facturar')
                                    @if (!$row->trashed())
                                        @if ($row->ultima_respuesta == null || optional($row->ultima_respuesta ?? null)->enlace_del_pdf == null)
                                            <button wire:click="enviarJson({{ $row->id }})"
                                                class="btn btn-circle btn-sm btn-warning"
                                                onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()">
                                                <i class="la la-gear"></i>
                                            </button>
                                        @endif
                                    @endif
                                @endcan
                                @can('intranet.caja.comprobante.delete')
                                    @if ($row->disponible_anulacion)
                                        @if (($row->ultima_respuesta != null || optional($row->ultima_respuesta ?? null)->errors != null) & !$row->trashed())
                                            <a href="#motivoAnulacionModal"
                                                wire:click="motivoAnulacion({{ $row->id }})"
                                                class="btn btn-circle btn-sm btn-error">
                                                <i class="la la-trash"></i>
                                            </a>
                                        @endif
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
