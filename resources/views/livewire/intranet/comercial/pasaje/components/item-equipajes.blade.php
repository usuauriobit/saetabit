@if ($pasaje->pasaje_bultos->count() > 0)
    <div class="my-1 p-1 border-4 border-secondary rounded-lg">
        @foreach ($pasaje->pasaje_bultos as $pasaje_bulto)
            <x-master.item>
                <x-slot name="label">
                    <small>
                        {{$pasaje_bulto->peso_total}} kg
                        @if ($pasaje_bulto->peso_excedido)
                            ({{ $pasaje_bulto->peso_excedido }} kg excedido)
                        @endif
                    </small>
                </x-slot>
                <x-slot name="sublabel">
                    <div class="badge badge-secondary badge-outline text-xs">
                        {{ optional($pasaje_bulto->tarifa_bulto)->tipo_bulto_desc }}
                    </div>
                    @if($pasaje_bulto->monto_exceso == 0)
                        <div class="badge badge-success badge-outline text-xs">
                            Registrado
                        </div>
                    @elseif (!$pasaje_bulto->has_venta_detalle)
                        <div class="badge badge-warning badge-outline text-xs">
                            Pendiente
                        </div>
                    @elseif(!$pasaje_bulto->is_pagado)
                        <div class="badge badge-warning text-xs">
                            Pendiente en caja
                        </div>
                    @else
                        <div class="badge badge-success text-xs">
                            Pagado
                        </div>
                    @endif
                </x-slot>
                <x-slot name="actions">
                    @if (!$pasaje_bulto->has_venta_detalle && (isset($vuelo) && !$vuelo->is_closed))
                        <button
                            wire:click="anularPasajeBulto({{ $pasaje_bulto->id }})"
                            class="btn btn-xs btn-danger"
                            onclick="confirm('¿Está seguro de eliminar? No podrá recuperarlo después')||event.stopImmediatePropagation()"
                        >
                            <i class="las la-trash"></i>
                        </button>
                    @endif
                </x-slot>
            </x-master.item>
        @endforeach
        @if ($this->can_generar_venta)
            <button
                onclick="confirm('¿Está seguro de eliminar? No podrá recuperarlo después')||event.stopImmediatePropagation()"
                class="btn btn-primary btn-sm mt-1 w-full"
                wire:click="generarVenta"
            >Guardar</button>
        @elseif($this->has_cancelar_caja_pendiente && Auth::user('intranet.caja.caja.index'))
            <a target="_blank" href="{{ route('intranet.caja.caja.index') }}" class="rounded btn btn-sm btn-primary mt-1 w-full">
                Confirmar en caja <i class="las la-angle-right"></i>
            </a>
        @endif
    </div>
@else
    <div class="badge">
        Sin bultos
    </div>
@endif
