<x-master.modal id-modal="addEscalaModal" label="Registro de incidencia de escala">
    <form wire:submit.prevent="registrarIncidenciaEscala"
        onsubmit="confirm('¿Está seguro?')||event.stopImmediatePropagation()">

        <div>
            @include('livewire.intranet.comercial.vuelo.components.section-incidencias.section-incidencia-ruta.alert-info-incidencia-escala')
            @if (!$escala)
                <livewire:intranet.comercial.vuelo.components.input-ubicacion label="Seleccionar la ubicación de escala"
                    nameEvent="escalaSelected" />
            @else
                <strong>Ubicación de escala</strong>
                <x-item.ubicacion :ubicacion="$escala">
                    <x-slot name="actions">
                        <button class="btn btn-outline btn-secondary" wire:click="removeEscala">
                            <i class="la la-refresh"></i>
                            Volver a elegir
                        </button>
                    </x-slot>
                </x-item.ubicacion>
            @endif
            <div class="mt-2">
                <x-master.input autocomplete="off" label="Ingrese descripción (Opcional)" name="descripcion"
                    wire:model.defer="descripcion"></x-master.input>

                <hr class="my-4">
                <x-master.item label="Fecha y hora de despegue"
                    sublabel="{{ $vuelo->fecha_hora_vuelo_programado->format('Y-m-d g:i a') }}">
                </x-master.item>

                <x-master.input autocomplete="off" required class="input_time" label="Hora de aterrizaje en escala"
                    name="fecha_hora_aterrizaje_primero_programado"
                    wire:model.defer="fecha_hora_aterrizaje_primero_programado" />
                <x-master.input autocomplete="off" required class="input_time" label="Hora de vuelo desde la escala"
                    name="fecha_hora_vuelo_programado" wire:model.defer="fecha_hora_vuelo_programado" />
                <x-master.input autocomplete="off" required class="input_time" label="Hora de aterrizaje en el destino"
                    name="fecha_hora_aterrizaje_ultimo_programado"
                    wire:model.defer="fecha_hora_aterrizaje_ultimo_programado" />
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
