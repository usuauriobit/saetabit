<div class="w-full">
    <div>
        @section('title', __('Crédito de vuelo'))
        <div class="cabecera p-6">
            <x-master.item label="Información de crédito de vuelo" sublabel="ID del crédito: {{ $vuelo_credito->id }}">
                <x-slot name="avatar">
                    <i class="la la-list"></i>
                </x-slot>
            </x-master.item>
        </div>
    </div>
    @if ($vuelo_credito->canCreateAmortizacion())
        <x-master.modal id-modal="addAmortizacionModal" label="Registrar amortización">
            <div x-data="{ tab: 'form' }">
                <div class="w-full tabs tabs-boxed">
                    <a class="tab" :class="tab == 'form' && 'tab-active'" x-on:click="tab = 'form'">Formulario</a>
                    <a class="tab" :class="tab == 'cuentas' && 'tab-active'" x-on:click="tab = 'cuentas'">Cuentas
                        referenciales</a>
                </div>
                <div x-show="tab == 'form'">
                    <x-master.input label="Fecha de pago" type="date" wire:model.defer="form.fecha_pago"
                        name="form.fecha_pago" />
                    <x-master.input prefix="S/" label="Monto" wire:model.defer="form.monto" name="form.monto"
                        type="number" />
                    <x-master.input label="Nro de cuenta" wire:model.defer="form.nro_cuenta" name="form.nro_cuenta" />
                    <x-master.input label="Descripción de cuenta" wire:model.defer="form.descripcion_cuenta"
                        name="form.descripcion_cuenta" />
                    <x-master.input label="Glosa" wire:model.defer="form.glosa" name="form.glosa" />
                </div>
                <div x-show="tab == 'cuentas'">
                    @foreach ($cuentas_referenciales as $cuenta)
                        <x-master.item class="my-3" :label="$cuenta->nro_cuenta" :sublabel="$cuenta->descripcion_cuenta">
                            <x-slot name="avatar">
                                <i class="la la-credit-card"></i>
                            </x-slot>
                            <x-slot name="actions">
                                <button wire:loading.attr="disabled" type="button"
                                    class="btn btn-primary btn-outline btn-sm" @click="tab = 'form'"
                                    wire:click="seleccionarCuenta({{ $cuenta->id }})">
                                    <i class="las la-paste"></i>
                                    Seleccionar
                                </button>
                            </x-slot>
                        </x-master.item>
                    @endforeach
                </div>
            </div>
            <button class="btn btn-primary w-full mt-4" wire:click="saveNewAmortizacion"
                onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()">
                <i class="la la-save"></i> &nbsp; Guardar
            </button>
        </x-master.modal>
    @endif
    <div class="grid grid-cols-3 gap-4">
        <div class="col-span-3">
            <x-item.vuelo-horizontal-simple hideAsientosDisponibles :vuelos="$vuelo_credito->vuelo_ruta->vuelos"></x-item.vuelo-horizontal-simple>

        </div>
        <div class="col-span-1 lg:col-span-1">
            <div class="card-white">
                <div class="card-body">
                    <x-master.item label="Cliente">
                        <x-slot name="sublabel">
                            {{ optional($vuelo_credito->clientable)->nombre_completo }} <br>
                            <strong>
                                {{ optional($vuelo_credito->clientable)->nro_doc }}
                            </strong>
                        </x-slot>
                        <x-slot name="avatar">
                            <i class="la la-user"></i>
                        </x-slot>
                    </x-master.item>
                    <x-master.item label="Glosa" class="mt-3">
                        <x-slot name="sublabel">
                            {{ $vuelo_credito->glosa }}
                        </x-slot>
                        <x-slot name="avatar">
                            <i class="la la-list"></i>
                        </x-slot>
                    </x-master.item>
                    <x-master.item label="Monto total" class="mt-3">
                        <x-slot name="sublabel">
                            @soles($vuelo_credito->monto)
                        </x-slot>
                        <x-slot name="avatar">
                            <i class="la la-dollar"></i>
                        </x-slot>
                    </x-master.item>
                    @if (!$vuelo_credito->is_pagado)
                        <x-master.item label="Monto pagado" class="mt-3">
                            <x-slot name="sublabel">
                                @soles($vuelo_credito->monto_pagado)
                            </x-slot>
                            <x-slot name="avatar">
                                <i class="la la-dollar"></i>
                            </x-slot>
                        </x-master.item>
                        <x-master.item label="Monto pendiente" class="mt-3">
                            <x-slot name="sublabel">
                                <div class="text-primary font-bold">
                                    @soles($vuelo_credito->monto_pago_pendiente)
                                </div>
                            </x-slot>
                            <x-slot name="avatar">
                                <i class="la la-dollar"></i>
                            </x-slot>
                        </x-master.item>
                    @endif
                    <x-master.item label="Estado" class="mt-3">
                        <x-slot name="sublabel">
                            @include('livewire.intranet.comercial.vuelo-credito.components.status')
                        </x-slot>
                    </x-master.item>
                </div>
            </div>
        </div>
        <div class="col-span-1 lg:col-span-2">
            <div class="cabecera p-6">
                <x-master.item label="Detalle de amortizaciones" sublabel="Historial de amortizaciones">
                    <x-slot name="avatar">
                        <i class="la la-list"></i>
                    </x-slot>
                    <x-slot name="actions">
                        @if ($vuelo_credito->canCreateAmortizacion())
                            <a class="btn btn-primary" href="#addAmortizacionModal">
                                <i class="la la-add"></i>
                                Agregar amortización
                            </a>
                        @endif
                    </x-slot>
                </x-master.item>
            </div>
            <div class="card-white">
                <div class="mt-2 overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Monto</th>
                                <th>Cuenta</th>
                                <th>Glosa</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vuelo_credito->amortizaciones as $amortizacion)
                                <tr>
                                    <td>{{ $amortizacion->id }}</td>
                                    <td>
                                        {{ optional($amortizacion->fecha_pago)->format('Y-m-d') }}
                                        {{-- <br>
                                        {{ optional($amortizacion->fecha_pago)->format('g:i a') }} --}}
                                    </td>
                                    <td>@soles($amortizacion->monto)</td>
                                    <td>
                                        <small>
                                            <strong>{{ $amortizacion->nro_cuenta }}</strong> <br>
                                            {{ $amortizacion->descripcion_cuenta }}
                                        </small>
                                    </td>
                                    <td>{{ $amortizacion->glosa }}</td>
                                    <td class="w-3">
                                        @can('intranet.comercial.vuelo-credito-amortizacion.delete')
                                            <button class="btn btn-circle btn-sm btn-danger"
                                                wire:click="delete({{ $amortizacion->id }})"
                                                onclick="confirm('¿Está seguro de eliminar?')||event.stopImmediatePropagation()">
                                                <i class="la la-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
