<div class="p-2 mb-3 card-white">
    <div class="flex items-center ">
        <button class="btn btn-outline btn-primary" :disabled="$wire.step == 1" type="button" wire:click="backStep">
            <i class="las la-angle-double-left"></i>
            Atrás
        </button>
        <ul class="w-full steps">
            <li class="step" :class="{ 'step-primary': $wire.step >= 1 }">Buscar vuelos</li>
            <li class="step" :class="{ 'step-primary': $wire.step >= 2 }">Pasajeros</li>
            <li class="step" :class="{ 'step-primary': $wire.step == 3 }">Resumen</li>
        </ul>
        <button x-show="$wire.step < 3" class="btn btn-outline btn-primary" :disabled="$wire.step == 3" type="button"
            wire:click="nextStep">
            Siguiente
            <i class="las la-angle-double-right"></i>
        </button>
        <button x-show="$wire.step == 3" class="btn btn-outline btn-primary" type="button"
            onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()" wire:click="save">
            Guardar
            <i class="las la-save"></i>
        </button>
    </div>
</div>
