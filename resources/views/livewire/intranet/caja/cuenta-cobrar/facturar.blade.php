<div>
    @include('components.alert-errors')
    <form wire:submit.prevent="save">
        <x-master.item label="Facturación Electrónica" class="col-span-3 my-4">
            <x-slot name="sublabel">
                Factura
            </x-slot>
            <x-slot name="actions">
                <button class="btn btn-warning btn-sm">Facturar</button>
                <a class="btn btn-primary btn-sm" href="{{ route('intranet.caja.cuenta-cobrar.show', $cuenta_cobrar) }}">
                    Volver
                </a>
            </x-slot>
        </x-master.item>
        <div class="card card-white">
            <div wire:loading>
                @include('components.loader-horizontal-sm')
            </div>
            <div class="card-body">
                <input type="text" name="form.caja_id" wire:model="form.caja_id" hidden>
                <div class="grid grid-cols-4 gap-4">
                    <x-master.select label="Caja" name="form.caja_id" wire:model="form.caja_id" :options="$cajas" />
                    <x-master.select label="Tipo de Comprobante" wire:change="setCorrelativoComprobante" name="form.tipo_comprobante_id" wire:model="form.tipo_comprobante_id" :options="$tipo_comprobantes" />
                    <x-master.item class="mt-5" label="Serie" sublabel="{{$form['serie'] ?? '-'}}"/>
                    <x-master.item class="mt-5" label="Correlativo" sublabel="{{$form['correlativo'] ?? '-'}}"/>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <x-master.select label="Tipo de Documento" name="form.tipo_documento_id" wire:model="form.tipo_documento_id" :options="$tipo_documentos" />
                    <div class="mt-2 form-control">
                        <label for="">N° Documento</label>
                        <div class="mt-1 input-group">
                          <input type="text" placeholder="Buscar…" class="w-full input input-bordered" type="number" name="form.nro_documento" wire:model="form.nro_documento" />
                          <button type="button" wire:click="buscarCliente" class="btn btn-square" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                          </button >
                        </div>
                    </div>
                    <x-master.input label="Denominación" type="text" name="form.denominacion" wire:model.defer="form.denominacion"/>
                </div>
                <x-master.input label="Dirección" type="text" name="form.direccion" wire:model.defer="form.direccion" />
                <div class="grid grid-cols-2 gap-4">
                    <x-master.select label="Moneda" name="form.moneda_id" wire:model="form.moneda_id" :options="$monedas" />
                    <x-master.select label="Tipo de Pago" name="form.tipo_pago_id" wire:model="form.tipo_pago_id" :options="$tipo_pagos" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-master.input label="Fecha Emisión" type="date" name="form.fecha_emision" wire:model.defer="form.fecha_emision" readonly/>
                    <x-master.input label="Fecha de Vencimiento" type="date" name="form.fecha_vencimiento" wire:model.defer="form.fecha_vencimiento" readonly/>
                </div>
                @if ($this->tipo_pago_desc == 'Crédito')
                    <div class="grid grid-cols-2 gap-4">
                        <div class="grid grid-cols-2 gap-4">
                            <x-master.input label="Fecha Pago" type="date" name="formCuota.fecha_pago_cuota" wire:model.defer="formCuota.fecha_pago_cuota"/>
                            {{-- <x-master.input label="Importe (S/.)" type="number" step="0.01" name="formCuota.importe" wire:model.defer="formCuota.importe"/> --}}
                            {{-- <a href="#" wire:click="addCuota" class="btn btn-success btn-sm mt-4" style="width: 35px;">
                                <i class="la la-plus"></i>
                            </a> --}}
                            <div class="mt-2 form-control">
                                <label for="">Importe (S/.)</label>
                                <div class="mt-1 input-group">
                                  <input class="w-full input input-bordered" type="number" step="0.01" name="formCuota.importe" wire:model.defer="formCuota.importe" />
                                  <a href="#" wire:click="addCuota" class="btn btn-square btn-success" >
                                    <i class="la la-plus"></i>
                                  </a >
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <h4>Cuotas</h4>
                            <table class="table w-full mt-2">
                                <thead>
                                    <tr>
                                        <th class="text-center">N°</th>
                                        <th class="text-center">Fecha Pago</th>
                                        <th class="text-center">Importe (S/.)</th>
                                        <th class="text-center">###</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (array_key_exists('cuotas', $form))
                                        @foreach ($form['cuotas'] as $cuota)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $cuota['fecha'] }}</td>
                                                <td class="text-right">{{ number_format($cuota['importe'], 2, '.', ',') }}</td>
                                                <td class="text-center">
                                                    <a href="#" wire:click="removeCuota({{ $loop->index }})" class="btn btn-error btn-sm">
                                                        <i class="la la-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right" colspan="2">Total</th>
                                        <th class="text-right">
                                            @if (array_key_exists('cuotas', $form))
                                                {{ "S/. " . number_format(collect($form['cuotas'])->sum('importe'), 2, '.', ',') }}
                                            @else
                                                0.00
                                            @endif
                                        </th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                @endif
                <div class="mt-2 mb-2 form-control">
                    <label for="">Observaciones</label>
                    <textarea class="textarea textarea-bordered" name="form.observaciones" wire:model.defer="form.observaciones"placeholder="Observaciones"></textarea>
                </div>
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
                        @foreach ($cuenta_cobrar->detalles as $item)
                            <tr>
                                <td>{{ $item->cantidad }}</td>
                                <td>-</td>
                                <td>-</td>
                                <td>{{ $item->concepto }}</td>
                                <td class="text-right">{{ number_format($item->importe, 2, '.', ',') }}</td>
                                <td class="text-right">{{ number_format($item->importe, 2, '.', ',') }}</td>
                                <td class="text-right">{{ number_format($item->importe, 2, '.', ',') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="6">Exonerada</th>
                            <th class="text-right">{{ "S/. " . number_format($cuenta_cobrar->detalles->sum('importe'), 2, '.', ',') }}</th>
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
                            <th class="text-right">{{ "S/. " . number_format($cuenta_cobrar->detalles->sum('importe'), 2, '.', ',') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </form>
</div>
