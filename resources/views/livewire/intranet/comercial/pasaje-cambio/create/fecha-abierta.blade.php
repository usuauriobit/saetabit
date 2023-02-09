<div>
    @include('components.alert-errors')

    <div class="my-4">
        <input type="checkbox" class="toggle" wire:model="is_sin_pagar"/> Sin cobro de penalidad
    </div>

    @if (!$is_sin_pagar)
        <x-master.input disabled prefix="S/." type="number" step="0.01" label="Importe de penalidad"
            wire:model.debounce.500ms="monto" name="importe_penalidad" />
    @endif
    <x-master.input label="Nota" wire:model.defer="nota" name="nota" />

    @if (!$pasaje->can_set_as_fecha_abierta || $is_sin_pagar)
        @include('components.alert-autorizacion')
        <livewire:intranet.components.modal-password-validation
            :is-modal="false"
            withObservacion
            :hasCancelBtn="false"
            permission="intranet.comercial.pasaje.cambio.fecha-abierta.create.super"
        />
    @else
        <button onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()" wire:loading.attr="disabled"
            wire:click="save" class="w-full mt-4 btn btn-primary">
            <i class="text-lg la la-save"></i> Guardar
        </button>
    @endif
</div>
