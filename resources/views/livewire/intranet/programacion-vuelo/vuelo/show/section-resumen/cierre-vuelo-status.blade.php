@if (!$vuelo->is_closed)
<div class="border-yellow-500 card-white">
    <div class="card-body">
        <div class="flex">
            <div class="flex-auto">
                <p>Para <strong> cerrar el vuelo </strong> se requiere:</p>
                <br>
                <ul>
                    <li>
                        @if ($vuelo->avion)
                        <i class="la la-check text-success"></i>
                        @endif Registrar avión
                    </li>
                    <li>
                        @if ($vuelo->tripulacion_vuelo->count() > 0)
                        <i class="la la-check text-success"></i>
                        @endif Registrar tripulación
                    </li>
                    <li>
                        @if (!$vuelo->has_pasajes_sin_pagar)
                        <i class="la la-check text-success"></i>
                        @endif No haber pasajes pendientes de pago
                    </li>
                </ul>
            </div>
            <div>
                @can('intranet.programacion-vuelo.vuelo.cerrar-vuelo')
                    @if ($vuelo->can_cerrar_vuelo)
                        <div style="text-align: right">
                            <button wire:click="closeFlight" wire:loading.attr='disabled' onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()" class="btn btn-success">
                                <i class="la la-check"></i>
                                Cerrar vuelo
                            </button>
                            <div class="text-sm">
                                El vuelo se cerrará con hora de despegue: {{ optional($this->vuelo->fecha_hora_vuelo_programado)->format('g:i a') }}
                                <br>Podrás modificarlo después desde la sección de monitoreo
                            </div>
                        </div>
                    @endif
                @endcan
            </div>
        </div>
    </div>
</div>
@else
    <div class="card-white">
        <div class="card-body">
            <div class="flex items-center justify-center">
                <div class="flex-auto">
                    <div class="text-h4">
                        Este vuelo se encuentra
                        <div class="badge badge-error">Cerrado</div>
                    </div>
                </div>
                @can('intranet.programacion-vuelo.vuelo.reabrir-vuelo')
                    <div class="">
                        <a href="#reabrirVueloModal" class="btn btn-primary">Reaperturar vuelo</a>
                        <livewire:intranet.components.modal-password-validation modal-name="reabrirVueloModal" eventName="reabrirVuelo" />
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endif
