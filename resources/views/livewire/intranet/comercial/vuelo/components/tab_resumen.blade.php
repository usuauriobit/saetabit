<x-master.item class="mb-6" label="Resumen" sublabel="Indicadores generales del vuelo">
    <x-slot name="avatar">
        <i class="las la-list-ul"></i>
    </x-slot>
    <x-slot name="actions">
        <a href="#cerrarVueloModal" class="btn btn-primary">Cerrar vuelo</a>
        @if (!$vuelo->is_closed && $vuelo->can_cerrar_vuelo)
        @endif
    </x-slot>
</x-master.item>
@if ($vuelo->can_cerrar_vuelo)
    <div class="border-yellow-500 card-white">
        <div class="card-body">
            <p>Para <strong> registrar la hora de despegue </strong> debe:</p>
            <br>
            <ul>
                {{-- <li> @if($vuelo->has_monitoreo) <i class="la la-check text-success"></i> @endif HABER REGISTRO DE MONITOREO DE DESPEGUE Y ATERRIZAJE</li> --}}
                <li> @if($vuelo->avion) <i class="la la-check text-success"></i> @endif HABER REGISTRO DE AVIÓN</li>
                <li> @if($vuelo->tripulacion_vuelo->count() > 0) <i class="la la-check text-success"></i> @endif HABER REGISTRO DE TRIPULACIÓN</li>
            </ul>
        </div>
    </div>
@endif
@if (!$vuelo->is_closed)
    <x-master.modal id-modal="cerrarVueloModal">
        <h4 class="text-lg font-semibold">Registro de cierre de vuelo</h4>
        <form wire:submit.prevent="closeFlight">
            <div wire:loading class="w-full">
                <div class="loader">Cargando...</div>
            </div>
            <div wire:loading.remove>
                <x-master.input autocomplete="off" label="Ingrese su contraseña" type="password" name="close_form.password" wire:model.defer="close_form.password"></x-master.input>
            </div>
            <div class="modal-action">
                <a href="#" class="btn btn-ghost">Cancelar</a>
                <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i>
                    Cerrar</button>
            </div>
        </form>
    </x-master.modal>
@endif

<div class="flex items-center justify-between my-4">
    <strong>Monitorio general</strong>
</div>
<div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
    <div class="p-4 card bg-gray-50">
        <x-widget1 title="Nro de asientos ofertados">
            <x-slot name="value">
                @if ($vuelo->nro_asientos_ofertados == 0)
                    <div class="text-md">No se registró</div>
                @else
                    {{$vuelo->nro_asientos_ofertados}}
                @endif
            </x-slot>
            <x-slot name="icon">
                <i class="text-4xl las la-couch text-info"></i>
            </x-slot>
        </x-widget1>
    </div>
    <div class="p-4 card bg-gray-50">
        <x-widget1 title="Nro de pasajes"
            value="{{$vuelo->pasajes->count()}}">
            <x-slot name="icon">
                <i class="text-4xl las la-users text-info"></i>
            </x-slot>
        </x-widget1>
    </div>
    <div class="p-4 card bg-gray-50">
        <x-widget1 title="Guías de despacho"
            value="{{optional($vuelo->guias_despacho)->count()}}">
            <x-slot name="icon">
                <i class="text-4xl las la-boxes text-info"></i>
            </x-slot>
        </x-widget1>
    </div>
</div>

@if ($vuelo->has_monitoreo)
    <div class="flex items-center justify-between my-4">
        <strong>Monitorio de tiempos de vuelo</strong>
        @if ($vuelo->can_editar_monitoreo)
            <a href="#setMonitoreo" class="btn btn-warning btn-sm btn-outline">
                <i class="la la-edit"></i> Editar monitoreo
            </a>
        @endif
    </div>
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <div class="p-4 card bg-gray-50">
            <x-widget1 title="Hora de despegue"
                value="{{ optional($vuelo->hora_despegue)->format('H:i') }}"
                diff-value="{{$vuelo->hora_despegue_diff}}"
                diff-suffix="min"
                diff-state="{{$vuelo->hora_despegue_diff >= 0 ? 'success' : 'warning'}}"
                footer-value="{{ optional($vuelo->fecha_hora_vuelo_programado)->format('H:i') }}"> >
                <x-slot name="icon">
                    <i class="text-4xl las la-clock text-success"></i>
                </x-slot>
            </x-widget1>
        </div>
        <div class="p-4 card bg-gray-50">
            <x-widget1 title="Hora de llegada"
                value="{{ optional($vuelo->hora_aterrizaje)->format('H:i') }}"
                diff-value="{{$vuelo->hora_aterrizaje_diff}}"
                diff-suffix="min"
                diff-state="{{$vuelo->hora_aterrizaje_diff <= 0 ? 'success' : 'warning'}}"
                footer-value="{{ optional($vuelo->fecha_hora_aterrizaje_programado)->format('H:i') }}">
                <x-slot name="icon">
                    <i class="text-4xl las la-clock text-info"></i>
                </x-slot>
            </x-widget1>
        </div>
        <div class="p-4 card bg-gray-50">
            <x-widget1 title="Tiempo de vuelo"
                value="{{$vuelo->tiempo_vuelo_real}}"
                diff-value="{{$vuelo->diferencia_tiempo_vuelo_min}}"
                diff-suffix="min"
                footer-value="{{ $vuelo->tiempo_vuelo }}"
                diff-state="{{$vuelo->tiempo_vuelo < $vuelo->tiempo_vuelo_real ? 'success' : 'warning' }}">
                <x-slot name="icon">
                    <i class="text-4xl las la-clock text-warning"></i>
                </x-slot>
            </x-widget1>
        </div>
    </div>
@else
    <div class="py-20 mt-4 text-center bg-gray-50">
        <a href="#setMonitoreo" class="btn btn-primary">Registrar monitoreo de despegue y aterrizaje</a>
    </div>
    <x-master.modal id-modal="setMonitoreo">
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
    </x-master.modal>
@endif



