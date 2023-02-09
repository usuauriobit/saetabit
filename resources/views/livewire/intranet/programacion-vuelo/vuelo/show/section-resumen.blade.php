<div>
    <x-master.item class="mb-6" label="Resumen" sublabel="Indicadores generales del vuelo">
        <x-slot name="avatar">
            <i class="las la-list-ul"></i>
        </x-slot>
        <x-slot name="actions">
            @if ($vuelo->is_closed)
                @can('intranet.programacion_vuelo.vuelo.reabrir-vuelo')
                    <a href="#cerrarVueloModal" class="btn btn-primary">Reaperturar vuelo</a>
                    <livewire:intranet.components.modal-password-validation modal-name="reabrirVueloModal" eventName="reabrirVuelo" />
                @endcan
            @endif
        </x-slot>
    </x-master.item>
    @include('livewire.intranet.programacion-vuelo.vuelo.show.section-resumen.cierre-vuelo-status')
    {{-- @include('livewire.intranet.programacion-vuelo.vuelo.show.section-resumen.confirm-cierre-vuelo-modal') --}}
    @include('livewire.intranet.programacion-vuelo.vuelo.show.section-resumen.monitoreo-despegue-aterrizaje')
    @include('livewire.intranet.programacion-vuelo.vuelo.show.section-resumen.section-monitoreo')
</div>
