<div class="w-full">
    <div>
        @section('title', __('Cuenta por Cobrar'))
        <div class="cabecera p-6">
            <x-master.item label="Información de cuenta por cobrar" sublabel="Código Cuenta: {{ $cuenta_cobrar->codigo }}">
                <x-slot name="avatar">
                    <i class="la la-list"></i>
                </x-slot>
                <x-slot name="actions">
                    @if ($cuenta_cobrar->disponible_facturar)
                        <a href="{{ route('intranet.caja.cuenta-cobrar.facturar', $cuenta_cobrar->id) }}" class="btn btn-warning btn-sm">
                            Facturar
                        </a>
                    @endif
                    <a href="{{ route('intranet.caja.cuenta-cobrar.index') }}" class="btn btn-primary btn-sm">
                        Volver
                    </a>
                </x-slot>
            </x-master.item>
        </div>
    </div>
    {{-- @if ($cuenta_cobrar->canCreateAmortizacion()) --}}
        @include('livewire.intranet.caja.cuenta-cobrar.components.modal-create-amortizacion')
        @include('livewire.intranet.caja.cuenta-cobrar.components.modal-create-detalle')
    {{-- @endif --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="col-span-1 lg:col-span-1">
            <div class="card-white">
                <div class="card-body">
                    <x-master.item label="Cliente">
                        <x-slot name="sublabel">
                            {{ $cuenta_cobrar->nombre_cliente }} <br>
                            <strong>
                                {{ optional($cuenta_cobrar->cliente)->nro_doc ?? optional($cuenta_cobrar->remitente ?? null)->nro_doc }}
                            </strong>
                        </x-slot>
                        <x-slot name="avatar">
                            <i class="la la-user"></i>
                        </x-slot>
                    </x-master.item>
                    <x-master.item label="Monto total" class="mt-3">
                        <x-slot name="sublabel">
                            @soles($cuenta_cobrar->importe)
                        </x-slot>
                        <x-slot name="avatar">
                            <i class="la la-dollar"></i>
                        </x-slot>
                    </x-master.item>
                    <x-master.item label="Monto pagado" class="mt-3">
                        <x-slot name="sublabel">
                            @soles($cuenta_cobrar->importe_pagado)
                        </x-slot>
                        <x-slot name="avatar">
                            <i class="la la-dollar"></i>
                        </x-slot>
                    </x-master.item>
                    <x-master.item label="Monto pendiente" class="mt-3">
                        <x-slot name="sublabel">
                            <div class="font-bold text-primary">
                                @soles($cuenta_cobrar->saldo)
                            </div>
                        </x-slot>
                        <x-slot name="avatar">
                            <i class="la la-dollar"></i>
                        </x-slot>
                    </x-master.item>
                    @if ($cuenta_cobrar->canCreateAmortizacion())
                        <div class="flex justify-center mt-3">
                            @if ($cuenta_cobrar->is_pagado)
                                <div class="badge badge-success" style="font-size: 25px;">¡Cancelado!</div>
                            @else
                                <div class="badge badge-warning" style="font-size: 25px;">¡Saldo Pendiente!</div>
                            @endif
                        </div>
                    @endif
                    @if ($cuenta_cobrar->disponible_facturar)
                        <div class="flex justify-center mt-4">
                            @if ($cuenta_cobrar->comprobante)
                                <div class="badge badge-success" style="font-size: 25px;">¡Facturado!</div>
                            @else
                                <div class="badge badge-warning" style="font-size: 25px;">¡Pendiente de Facturación!</div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-span-1 lg:col-span-2">
            <div class="mt-3 tabs tabs-boxed">
                <a class="tab {{ $tab == 'detalles' ? 'tab-active' : '' }}" wire:click="setTab('detalles')">Detalle</a>
                <a class="tab {{ $tab == 'amortizaciones' ? 'tab-active' : '' }}"
                    wire:click="setTab('amortizaciones')">Amortizaciones</a>
                <a class="tab" wire:loading>
                    @include('components.loader-horizontal-sm')
                </a>
            </div>
            <div class="">
                @if ($tab == 'detalles')
                    @include('livewire.intranet.caja.cuenta-cobrar.components.tab-detalles')
                @endif
                @if ($tab == 'amortizaciones')
                    @include('livewire.intranet.caja.cuenta-cobrar.components.tab-amortizaciones')
                @endif
            </div>
        </div>
    </div>
</div>
