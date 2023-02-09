<div x-data="{ tab: 'ida' }">
    @include('components.alert-errors')
    @if ($this->alreadySetId && optional($this->tipo_vuelo)->is_charter)
        @include('livewire.intranet.comercial.adquisicion-pasaje.components.charter_header')
    @else
        @include('livewire.intranet.comercial.adquisicion-pasaje.components.stepper_header')
    @endif
    <div class="mx-4">
        @switch($step)
            @case(1)
                @include('livewire.intranet.comercial.adquisicion-pasaje.components.step_buscar_vuelos')
            @break

            @case(2)
                @include('livewire.intranet.comercial.adquisicion-pasaje.components.section-pasajes')
            @break

            @default
                @include('livewire.intranet.comercial.adquisicion-pasaje.components.resumen')
        @endswitch
    </div>
</div>
