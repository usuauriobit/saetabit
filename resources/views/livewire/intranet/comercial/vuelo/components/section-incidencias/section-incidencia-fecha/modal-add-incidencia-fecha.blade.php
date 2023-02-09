<x-master.modal id-modal="addFechaIncidenciaModal" label="Registro de incidencia de fechas">
    <form wire:submit.prevent="registrarIncidenciaFecha"
        onsubmit="confirm('¿Está seguro?')||event.stopImmediatePropagation()">

        <div>
            @include('livewire.intranet.comercial.vuelo.components.section-incidencias.section-incidencia-fecha.alert-info-incidencia-escala')
            <div class="mt-2">
                <x-master.input autocomplete="off" label="Ingrese descripción (Opcional)" name="descripcion"
                    wire:model.defer="descripcion"></x-master.input>

                <hr class="my-4">
                <x-master.item class="my-2" label="Fecha y hora de despegue actual"
                    sublabel="{{ optional($vuelo->fecha_hora_vuelo_programado)->format('Y-m-d g:i a') }}">
                </x-master.item>
                <x-master.item class="my-2" label="Fecha y hora de aterrizaje actual"
                    sublabel="{{ optional($vuelo->fecha_hora_aterrizaje_programado)->format('Y-m-d g:i a') }}">
                </x-master.item>

                <x-master.input autocomplete="off" required class="input_date_time" label="Fecha y hora de despegue"
                    name="fecha_hora_vuelo_programado" wire:model.defer="fecha_hora_vuelo_programado" />
                <x-master.input autocomplete="off" required class="input_date_time" label="Fecha y hora de aterrizaje"
                    name="fecha_hora_aterrizaje_programado" wire:model.defer="fecha_hora_aterrizaje_programado" />
                <div class="mt-2">
                    @include('components.alert-errors')
                </div>
            </div>
        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary">
                <i class="la la-save"></i>
                Guardar
            </button>
        </div>
    </form>
</x-master.modal>
