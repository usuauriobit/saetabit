<div class="bg-gray-50 p-4 my-3 rounded-box">
    <div class="flex justify-between items-center pb-4">
        <div class="text-xl font-bold">
            Incidencias de avión
        </div>

    </div>
    @forelse ($vuelo->incidencias_avion as $incidencia)
        <x-master.item label="Avión que sufrió la incidencia" sublabel="{{optional($incidencia->avion_before)->matricula}}">
            <x-slot name="avatar">
                <i class="la la-plane"></i>
            </x-slot>
            <x-slot name="actions">
                <button wire:loading.attr="disabled"  class="btn btn-danger btn-sm mt-4" wire:click="deleteIncidenteAvion('{{$incidencia->id}}')">
                    <i class="la la-times"></i> Eliminar
                </button>
            </x-slot>
        </x-master.item>
        <x-master.item label="Avión que lo reemplazó" sublabel="{{optional($incidencia->avion_after)->matricula}}">
            <x-slot name="avatar">
                <i class="la la-plane"></i>
            </x-slot>
        </x-master.item>
        <x-master.item label="Descripción de la incidencia" sublabel="{{$incidencia->descripcion}}">
            <x-slot name="avatar">
                <i class="las la-tasks"></i>
            </x-slot>
        </x-master.item>
    @empty
        @if ($is_avion)
            @if ($avion)
                <x-master.item label="Avión que sufrió en incidente" sublabel="{{$avion->matricula}}">
                    <x-slot name="avatar">
                        <i class="la la-plane"></i>
                    </x-slot>
                    <x-slot name="actions">
                        <button wire:click="removeAvion" class="btn btn-sm btn-danger">
                            <i class="las la-times"></i>
                        </button>
                    </x-slot>
                </x-master.item>
            @else
                <livewire:intranet.comercial.vuelo.components.input-avion emitEvent="avionIncidenteSelected" />
            @endif

            <x-master.input label="Descripcion de la incidencia" name="form.descripcion_avion" wire:model="form.descripcion_avion" />
            <button class="btn btn-primary w-full mt-3" wire:loading.attr="disabled"  wire:click="saveAvion"> <i class="la la-save"></i> Guardar</button>
        @else
            <div class="my-2 text-gray-500">
                <strong>No hay incidencias de avión</strong>
            </div>
            @if ($vuelo->avion)
                <button class="btn btn-primary" wire:click="setAvionState({{true}})">Registrar incidencia</button>
            @else
                <div class="text-yellow-600">El vuelo aún no tiene avión asignado</div>
            @endif
        @endif
    @endforelse
</div>
