<div>
    @include('components.alert-errors')
    <form wire:submit.prevent="save">
        <x-master.item label="Facturación Electrónica" class="col-span-3 my-4">
            <x-slot name="sublabel">
                Factura
            </x-slot>
            <x-slot name="actions">
                <button class="btn btn-warning btn-sm">Facturar</button>
                @if($comprobante_modifica)
                    <a class="btn btn-primary btn-sm" href="{{ route('intranet.caja.comprobante.index') }}">
                        Volver
                    </a>
                @endisset
                @if ($documento)
                    <a class="btn btn-primary btn-sm" href="{{ route('intranet.caja.venta.show', [ 'venta' => $documento->id, 'caja_apertura_id' => $caja_apertura_cierre->id, 'caja_id' => $caja->id ]) }}">
                        Volver
                    </a>
                @endif
            </x-slot>
        </x-master.item>
        <div class="card card-white">
            <div wire:loading>
                @include('components.loader-horizontal-sm')
            </div>
            <div class="card-body">
                <input type="text" name="form.caja_apertura_cierre_id" wire:model="form.caja_apertura_cierre_id" hidden>
                <div class="grid grid-cols-3 gap-4">
                    <x-master.select label="Tipo de Comprobante" wire:change="setCorrelativoComprobante()" name="form.tipo_comprobante_id" wire:model="form.tipo_comprobante_id" :options="$tipo_comprobantes" :disabled="isset($comprobante_modifica)" />
                    <x-master.item class="mt-5" label="Serie" sublabel="{{$form['serie'] ?? '-'}}"/>
                    <x-master.item class="mt-5" label="Correlativo" sublabel="{{$form['correlativo'] ?? '-'}}"/>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <x-master.select label="Tipo de Documento" name="form.tipo_documento_id" wire:model="form.tipo_documento_id" :options="$tipo_documentos" :disabled="isset($comprobante_modifica)" />
                    <div class="mt-2 form-control">
                        <label for="">N° Documento</label>
                        <div class="mt-1 input-group">
                          <input type="text" placeholder="Buscar…" class="w-full input input-bordered" type="number" name="form.nro_documento" wire:model="form.nro_documento" {{ isset($comprobante_modifica) ? 'disabled' : '' }} />
                          <button type="button" wire:click="buscarCliente" class="btn btn-square" {{ isset($comprobante_modifica) ? 'disabled' : '' }} >
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                          </button >
                        </div>
                    </div>
                    <x-master.input label="Denominación" type="text" name="form.denominacion" wire:model.defer="form.denominacion" :disabled="isset($comprobante_modifica)" />
                </div>
                <x-master.input label="Dirección" type="text" name="form.direccion" wire:model.defer="form.direccion" />
                <div class="grid grid-cols-2 gap-4">
                    <x-master.select label="Moneda" name="form.moneda_id" wire:model="form.moneda_id" :options="$monedas" />
                    @if($comprobante_modifica == null)
                        <x-master.select label="Tipo de Pago" name="form.tipo_pago_id" wire:model="form.tipo_pago_id" :options="$tipo_pagos" />
                    @endif
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-master.input label="Fecha Emisión" type="date" name="form.fecha_emision" wire:model.defer="form.fecha_emision" readonly/>
                    <x-master.input label="Fecha de Vencimiento" type="date" name="form.fecha_vencimiento" wire:model.defer="form.fecha_vencimiento" readonly/>
                </div>
                @if ($this->tipo_pago_desc == 'Crédito')
                    <div class="grid grid-cols-2 gap-4">
                        <x-master.input label="Fecha Inicio de Pago" type="date" name="form.fecha_credito" wire:model.defer="form.fecha_credito"/>
                        <x-master.input label="N° de Cuotas" type="number" step="1" name="form.nro_cuotas" wire:model.defer="form.nro_cuotas"/>
                    </div>
                @endif
                <div class="mt-2 mb-2 form-control">
                    <label for="">Observaciones</label>
                    <textarea class="textarea textarea-bordered" name="form.observaciones" wire:model.defer="form.observaciones"placeholder="Observaciones"></textarea>
                </div>
                @isset($comprobante_modifica)
                    <div class="grid grid-cols-3 gap-4">
                        <input type="text" name="form.comprobante_modifica_id" wire:model="form.comprobante_modifica_id" hidden>
                        <x-master.select label="Tipo de Nota de Crédito" name="form.tipo_nota_credito_id" wire:model="form.tipo_nota_credito_id" :options="$tipo_nota_creditos" />
                        <x-master.input label="Serie Documento a Modificar " type="text" name="form.serie_documento_modifica" wire:model.defer="form.serie_documento_modifica" readonly/>
                        <x-master.input label="Correlativo Documento a Modificar" type="text" name="form.correlativo_documento_modifica" wire:model.defer="form.correlativo_documento_modifica" readonly/>
                    </div>
                @else
                    <table class="table w-full mt-2">
                        <thead>
                            <tr>
                                <th>Cant.</th>
                                <th>UM.</th>
                                <th>Cod.</th>
                                <th>Descripción</th>
                                <th>V/U</th>
                                <th>P/U</th>
                                <th>Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documento->detalle as $item)
                                <tr>
                                    <td>{{ $item->cantidad }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $item->descripcion }}</td>
                                    <td class="text-right">{{ number_format($item->monto, 2, '.', ',') }}</td>
                                    <td class="text-right">{{ number_format($item->monto, 2, '.', ',') }}</td>
                                    <td class="text-right">{{ number_format($item->importe, 2, '.', ',') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right" colspan="6">Exonerada</th>
                                <th class="text-right">{{ "S/. " . number_format($documento->detalle->sum('monto'), 2, '.', ',') }}</th>
                            </tr>
                            <tr>
                                <th class="text-right" colspan="6">Gravada</th>
                                <th class="text-right">{{ "S/. " . number_format(0, 2, '.', ',') }}</th>
                            </tr>
                            <tr>
                                <th class="text-right" colspan="6">IGV 18.00 %</th>
                                <th class="text-right">{{ "S/. " . number_format(0, 2, '.', ',') }}</th>
                            </tr>
                            <tr>
                                <th class="text-right" colspan="6">Total</th>
                                <th class="text-right">{{ "S/. " . number_format($documento->detalle->sum('monto'), 2, '.', ',') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                @endisset

            </div>
        </div>
    </form>
</div>
