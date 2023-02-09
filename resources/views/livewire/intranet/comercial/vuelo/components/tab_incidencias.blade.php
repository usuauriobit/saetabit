<div>
    <x-master.item label="Incidencias" sublabel="Registro de incidencias ocurridos en el vuelo">
        <x-slot name="avatar">
            <i class="las la-exclamation-triangle"></i>
        </x-slot>
        <x-slot name="actions">

        </x-slot>
    </x-master.item>


    <livewire:intranet.comercial.vuelo.components.section-incidencias key="{{ now() }}" :vuelo="$vuelo" />
</div>
