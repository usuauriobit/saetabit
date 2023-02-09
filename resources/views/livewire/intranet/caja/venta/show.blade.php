<div class="p-2">
    @isset($venta->comprobante->ultima_respuesta)
        @if (optional($venta->comprobante->ultima_respuesta ?? null)->enlace_del_pdf == '')
            <div class="shadow-lg alert alert-warning">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 stroke-current" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>¡Atención! Hubo problemas en la facturación. Desde el módulo de Comprbantes, envíe nuevamente el documento.</span>
                </div>
            </div>
        @endif
    @endisset
    <x-master.item label="Registro de Movimiento" class="col-span-3 my-4">
        <x-slot name="sublabel">
            Venta: {{ $venta->codigo }}
        </x-slot>
        <x-slot name="actions">
            @if (optional($venta->comprobante->ultima_respuesta ?? null)->enlace_del_pdf != '')
                <a href="{{ optional($venta->comprobante->ultima_respuesta ?? null)->enlace_del_pdf }}"
                    class="btn btn-success btn-sm" target="_blank">
                    <i class="la la-file"></i> Facturado
                </a>
            @else
                @if ($venta->is_pagado & $venta->disponible_facturar)
                    @can('intranet.caja.facturacion.create')
                        <a class="mr-2 btn btn-warning btn-sm" href="{{ route('intranet.caja.facturacion.create', [
                            'documentable_id' => $venta->id,
                            'documentable_type' => get_class($venta),
                            'caja_apertura_cierre_id' => $caja_apertura_cierre->id,
                            'caja_id' => $caja->id,
                        ]) }}">Facturar</a>
                    @endcan
                @endif
            @endif
            <a class="btn btn-warning btn-sm" href="{{ route('intranet.caja.venta.index') }}">Ir a Ventas</a>
            @isset($caja_apertura_cierre)
                <a class="btn btn-primary btn-sm" href="{{ route('intranet.caja.caja.show', $caja_apertura_cierre->caja_id) }}">Volver</a>
            @endisset
        </x-slot>
    </x-master.item>
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-4">
        <div>
            <x-master.item label="VENTA" class="my-4" sublabel="Detalle de la Venta"></x-master.item>
            <div class="card card-white">
                <div class="card-body">
                    <div class="grid grid-cols-2 gap-4">
                        <x-master.item class="my-3" label="Cliente">
                            <x-slot name="sublabel">
                                {{ optional($venta->clientable)->nombre_completo }} <br>
                                <strong>{{$venta->clientable->nro_doc}}</strong>
                            </x-slot>
                        </x-master.item>
                        <x-master.item class="my-3" label="Fecha">
                            <x-slot name="sublabel">
                                {{ optional($venta->created_at)->format('d-m-Y') }} <br>
                            </x-slot>
                        </x-master.item>
                    </div>
                    <div class="stats">
                        <div class="stat">
                            <div class="stat-title font-bold">Total</div>
                            <div class="stat-value">@soles($venta->importe)</div>
                        </div>
                    </div>
                    <div class="stats">
                        <div class="stat">
                            <div class="stat-title font-bold">Total Pagado</div>
                            <div class="stat-value">@soles($venta->total_pagado)</div>
                        </div>
                    </div>
                    <div class="stats">
                        <div class="stat">
                            <div class="stat-title font-bold">Total Facturado</div>
                            <div class="stat-value">@soles($venta->total_facturado)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-3">
            @include('livewire.intranet.caja.venta.components.section-movimiento')
            @include('livewire.intranet.caja.venta.components.section-detalle')
            @include('livewire.intranet.caja.venta.components.create-movimiento')
        </div>
    </div>
</div>
