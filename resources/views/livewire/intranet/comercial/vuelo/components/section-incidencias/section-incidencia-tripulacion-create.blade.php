<div>
    <div class="text-center">
        <i class="text-4xl text-blue-500 la la-user"></i>
        <p>
            <strong>{{ $tripulacionVueloActual->nombre_completo }}</strong>
            <br>
            <span>{{ optional($tripulacionVueloActual->tripulacion)->nro_licencia }}</span>
        </p>
    </div>
    <div class="mt-4 text-gray-400">
        Reemplazado por:
    </div>
    @if ($tripulacion_new)
        <x-master.item label="{{$tripulacion_new->nombre_completo}}" sublabel="{{$tripulacion_new->nro_licencia}}">
            <x-slot name="avatar">
                <i class="la la-user"></i>
            </x-slot>
            <x-slot name="actions">
                <button class="btn btn-danger btn-sm" wire:click="deleteNewTripulacion">
                    <i class="la la-times"></i>
                </button>
            </x-slot>
        </x-master.item>
    @else
        <livewire:intranet.comercial.vuelo.components.input-tripulacion key="trip{{$tripulacionVueloActual->id}}" emitUp sendEvent="tripulacionIncidenciaSelected" :type="optional(optional($tripulacionVueloActual->tripulacion)->tipo_tripulacion)->descripcion" />
    @endif
    <x-master.input label="Descripcion de la incidencia" name="form.descripcion_tripulacion" wire:model="form.descripcion_tripulacion" />
    <button class="w-full mt-3 btn btn-primary" wire:loading.attr="disabled"  wire:click="saveIncidencia"> <i class="la la-save"></i> Guardar</button>
</div>
