@if ($vuelo->has_monitoreo)
<div class="flex items-center justify-between my-4">
        <p class="text-xl font-bold">Monitorio de tiempos de vuelo</p>
        @if ($vuelo->can_editar_monitoreo)
            @include('livewire.intranet.programacion-vuelo.vuelo.show.section-resumen.modal-despegue-aterrizaje')
            <div style="text-align: right">
                <a href="#setMonitoreo" class="btn btn-warning btn-sm btn-outline">
                    <i class="la la-edit"></i> Editar monitoreo
                </a>
                <p>
                    Quedan {{ $vuelo->dias_disponibles_para_editar_monitoreo }} días disponibles para editar el monitoreo
                </p>
            </div>
        @endif
    </div>
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <div class="p-4 card-white bg-gray-50">
            <x-widget1 title="Hora de despegue" value="{{ optional($vuelo->hora_despegue)->format('Y-m-d g:i a') }}"
                diff-value="{{ $vuelo->hora_despegue_diff }}" diff-suffix="min"
                diff-state="{{ $vuelo->hora_despegue_diff >= 0 ? 'success' : 'warning' }}"
                icon=""
                footer-value="{{ optional($vuelo->fecha_hora_vuelo_programado)->format('Y-m-d g:i a') }}"> >
                <x-slot name="icon">
                    <i class="text-4xl las la-clock text-success"></i>
                </x-slot>
            </x-widget1>
        </div>
        <div class="p-4 card-white bg-gray-50">
            <x-widget1 title="Hora de llegada" value="{{ optional($vuelo->hora_aterrizaje)->format('Y-m-d g:i a') }}"
                diff-value="{{ $vuelo->hora_aterrizaje_diff }}" diff-suffix="min"
                diff-state="{{ $vuelo->hora_aterrizaje_diff <= 0 ? 'success' : 'warning' }}"
                icon=""
                footer-value="{{ optional($vuelo->fecha_hora_aterrizaje_programado)->format('Y-m-d g:i a') }}">
                <x-slot name="icon">
                    <i class="text-4xl las la-clock text-info"></i>
                </x-slot>
            </x-widget1>
        </div>
        <div class="p-4 card-white bg-gray-50">
            <x-widget1 title="Tiempo de vuelo" value="{{ $vuelo->tiempo_vuelo_real }}"
                diff-value="{{ $vuelo->diferencia_tiempo_vuelo_min }}" diff-suffix="min"
                footer-value="{{ $vuelo->tiempo_vuelo }}"
                icon=""
                diff-state="{{ $vuelo->tiempo_vuelo < $vuelo->tiempo_vuelo_real ? 'success' : 'warning' }}">
                <x-slot name="icon">
                    <i class="text-4xl las la-clock text-warning"></i>
                </x-slot>
            </x-widget1>
        </div>
    </div>
@else
    @if (!$vuelo->is_closed)
        <div class="alert alert-info my-4">
            <div>
                <i class="la la-info-circle mr-2" style="font-size: 20px"></i>
                Para registrar monitoreo de hora de despegue y aterrizaje debe &nbsp; <strong> cerrar el vuelo</strong>
            </div>
        </div>
    @else

    @can('intranet.programacion-vuelo.vuelo.cerrar-vuelo')
    <div class="card-white my-4">
        <div class="card-body">
            <div class="text-lg font-bold">Registro de monitoreo de vuelo</div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-center">
                <x-master.input id="input_hora_despegue" name="monitoreo_form.hora_despegue"
                    wire:model="monitoreo_form.hora_despegue" label="Hora de despegue"></x-master.input>
                @if (!$error_hora_aterrizaje)
                    <x-master.input readonly name="hora_aterrizaje_visual" value="{{ $this->hora_aterrizaje }}"
                        label="Hora de aterrizaje" altLabelBL="*Puede cambiar este valor después"></x-master.input>
                    <livewire:intranet.components.modal-password-validation modal-name="cerrarVueloModal"
                        eventName="cerrarVuelo" />
                    <a href="#cerrarVueloModal" class="btn btn-primary w-full">Registrar</a>
                @endif
            </div>
            @if ($error_hora_aterrizaje)
                <div class="text-danger">{{ $error_hora_aterrizaje }}</div>
                <small>
                    NOTA: Revise si el tiempo de vuelo está correctamente registrado
                    con el avión (Matrícula {{optional($vuelo->avion)->matricula}})
                    y tramo ({{$vuelo->ruta_descripcion}}).
                    Puede verlo desde el módulo de mantenimiento de aviones.
                </small>
            @endif
        </div>
    </div>
    @endcan
    {{-- <x-master.modal id-modal="setMonitoreo">
        <h4 class="text-lg font-semibold">Registrar monitoreo de despegue y aterrizaje</h4>
        <form wire:submit.prevent="setMonitoreo">
            <div wire:loading class="w-full">
                <div class="loader">Cargando...</div>
            </div>
            <div wire:loading.remove>
                <x-master.input id="input_hora_despegue" autocomplete="off" label="Hora de despegue" name="monitoreo_form.hora_despegue" wire:model.defer="monitoreo_form.hora_despegue"></x-master.input>
                <x-master.input id="input_hora_aterrizaje" autocomplete="off" label="Hora de aterrizaje" name="monitoreo_form.hora_aterrizaje" wire:model.defer="monitoreo_form.hora_aterrizaje"></x-master.input>
            </div>
            <div class="modal-action">
                <a href="#" class="btn btn-ghost">Cancelar</a>
                <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i>
                    Guardar</button>
            </div>
        </form>
    </x-master.modal> --}}
    @endif
@endif


    {{-- <x-master.modal id-modal="setMonitoreo">
        <h4 class="text-lg font-semibold">Registrar monitoreo de despegue y aterrizaje</h4>
        <form wire:submit.prevent="setMonitoreo">
            <div wire:loading class="w-full">
                <div class="loader">Cargando...</div>
            </div>
            <div wire:loading.remove>
                <x-master.input id="input_hora_despegue" autocomplete="off" label="Hora de despegue"
                    name="monitoreo_form.hora_despegue" wire:model.defer="monitoreo_form.hora_despegue">
                </x-master.input>
                <x-master.input id="input_hora_aterrizaje" autocomplete="off" label="Hora de aterrizaje"
                    name="monitoreo_form.hora_aterrizaje" wire:model.defer="monitoreo_form.hora_aterrizaje">
                </x-master.input>
            </div>
            <div class="modal-action">
                <a href="#" class="btn btn-ghost">Cancelar</a>
                <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i
                        class="la la-save"></i>
                    Guardar</button>
            </div>
        </form>
    </x-master.modal> --}}
