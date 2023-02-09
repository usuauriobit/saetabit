<div>
    @include('components.alert-errors')
    @if ($nueva_persona)
        <x-master.item label="Nuevo pasajero">
            <x-slot name="sublabel">
                {{ $nueva_persona->nombre_short }}
                <div class="badge success">
                    {{ $nueva_persona->nro_doc }}
                </div>
            </x-slot>
            <x-slot name="actions">
                <button class="btn btn-primary btn-outline" wire:click="eliminarPersona">
                    <i class="la la-trash"></i>
                </button>
            </x-slot>
        </x-master.item>
    @else
        <livewire:intranet.components.input-persona />
    @endif

    <div class="my-4">
        <input type="checkbox" class="toggle" wire:model="is_sin_pagar"> Sin cobro de penalidad
    </div>

    @if (!$is_sin_pagar)
        <x-master.input disabled prefix="S/." type="number" step="0.01" label="Importe de penalidad"
            wire:model.debounce.500ms="monto" name="importe_penalidad" />
    @else
        @include('livewire.intranet.comercial.pasaje-cambio.components.alert-sin-pago-info')
    @endif

    <x-master.input label="Nota" wire:model.defer="nota" name="nota" />


    @if (!$pasaje->can_cambio_titularidad || $is_sin_pagar)
        @include('components.alert-autorizacion')
        <livewire:intranet.components.modal-password-validation
            :is-modal="false"
            withObservacion
            :shouldCloseModal="false"
            :hasCancelBtn="false"
            permission="intranet.comercial.pasaje.cambio.titular.create.super"
        />
    @else
        <button onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()" wire:loading.attr="disabled"
            wire:click="saveCambioTitularidad" class="w-full mt-4 btn btn-primary">
            <i class="text-lg la la-save"></i> Guardar
        </button>
    @endif

</div>
