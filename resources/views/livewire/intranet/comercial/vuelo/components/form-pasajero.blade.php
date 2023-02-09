<div>
    <div x-data="{ tab_pasajero: 'persona' }">
        <form wire:submit.prevent="setPasaje">

            @include('components.alert-errors')

            <span class="text-xl font-bold">Agregar persona</span>

            @if (!$persona)
                <livewire:intranet.components.input-persona emit-event="pasajeroFounded" label="Buscar persona" />
            @endif

            @if ($persona)
                @include('livewire.intranet.comercial.vuelo.components.form-pasajero.form-add')
            @endif

            <div wire:loading class="w-full">
                <div class="loader">Cargando...</div>
            </div>
        </form>
    </div>
</div>
