<div class="cabecera p-6">
    <x-master.item label="Detalle de amortizaciones" sublabel="Historial de amortizaciones">
        <x-slot name="avatar">
            <i class="la la-list"></i>
        </x-slot>
        <x-slot name="actions">
            @can('intranet.caja.cuenta-cobrar.amortizacion.create')
                @if (!$cuenta_cobrar->is_pagado)
                    <a class="btn btn-success btn-sm" href="#addAmortizacionModal">
                        <i class="la la-add"></i>
                        Agregar amortización
                    </a>
                @endif
            @endcan
        </x-slot>
    </x-master.item>
</div>
<div class="card-white">
    <div class="mt-2 overflow-x-auto">
        <table class="table w-full">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">ID</th>
                    <th class="text-center">Monto</th>
                    <th class="text-center">Cuenta</th>
                    <th class="text-center">Glosa</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cuenta_cobrar->amortizaciones as $amortizacion)
                    <tr>
                        <td>{{ $amortizacion->id }}</td>
                        <td>
                            {{ optional($amortizacion->fecha_pago)->format('Y-m-d') }}
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
                            @can('intranet.caja.cuenta-cobrar.amortizacion.delete')
                                <button class="btn btn-circle btn-sm btn-error" wire:click="deleteAmortizacion({{ $amortizacion->id }})"
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
