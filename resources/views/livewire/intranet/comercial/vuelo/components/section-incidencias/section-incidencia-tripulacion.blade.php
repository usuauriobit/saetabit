<div class="p-4 my-3 bg-gray-50 rounded-box">
    <div class="flex items-center justify-between pb-4">
        <div class="text-xl font-bold">
            Incidencias de tripulación
        </div>
    </div>
    @forelse ($vuelo->incidencias_tripulacion as $incidencia)
        <div class="p-4 mb-4 bg-white">
            <x-master.item label="Tripulación que sufrió la incidencia" sublabel="{{optional($incidencia->tripulacion_vuelo_before)->nombre_completo}}">
                <x-slot name="avatar">
                    <i class="la la-user"></i>
                </x-slot>
                <x-slot name="actions">
                    @if ($incidencia->actually_in_vuelo)
                        <button wire:loading.attr="disabled"  class="mt-4 btn btn-danger btn-sm" wire:click="deleteIncidenteTripulacion('{{$incidencia->id}}')">
                            <i class="la la-times"></i> Eliminar
                        </button>
                    @endif
                </x-slot>
            </x-master.item>
            <x-master.item label="Tripulación que lo reemplazó" sublabel="{{optional($incidencia->tripulacion_vuelo_after)->nombre_completo}}">
                <x-slot name="avatar">
                    <i class="la la-user"></i>
                </x-slot>
            </x-master.item>
            <x-master.item label="Descripción de la incidencia" sublabel="{{$incidencia->descripcion}}">
                <x-slot name="avatar">
                    <i class="las la-tasks"></i>
                </x-slot>
            </x-master.item>
        </div>
    @empty
        <div class="my-2 text-gray-500">
            <strong>No hay incidencias de tripulación</strong>
        </div>
    @endforelse

    @if ($is_active)
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            @foreach ($vuelo->tripulacion_vuelo as $tripulacion_vuelo)
                <livewire:intranet.comercial.vuelo.components.section-incidencias.section-incidencia-tripulacion-create key="{{ now() }}" :tripulacionVueloActual="$tripulacion_vuelo" />
            @endforeach
        </div>
    @else
        @if (count($vuelo->tripulacion_vuelo) > 0)
            <button class="btn btn-primary" wire:click="setTripulacionState({{true}})">Registrar incidencia</button>
        @else
            <div class="text-yellow-600">El vuelo aún no tiene tripulación asignado</div>
        @endif
    @endif
</div>
