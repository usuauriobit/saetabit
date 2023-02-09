<div>
    <x-master.item label="Tripulación" sublabel="Lista de personas que forman parte de la tripulación">
        <x-slot name="avatar">
            <i class="las la-user-friends"></i>
        </x-slot>
        <x-slot name="actions">
            {{-- @if (!$vuelo->is_closed)
                <button class="btn btn-primary">Registrar carga</button>
            @endif --}}
        </x-slot>
    </x-master.item>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        <div class="p-4 bg-gray-50">
            <div class="text-center">
                <i class="text-4xl text-blue-500 las la-male"></i>
                <div>
                    <strong>Piloto</strong>
                </div>
            </div>
            @if ($vuelo->piloto_vuelo)
                <x-master.item class="mt-3"
                    label="{{optional($vuelo->piloto_vuelo)->nombre_completo}}"
                    sublabel="{{optional(optional($vuelo->piloto_vuelo)->tripulacion)->nro_licencia}}"
                    >
                    @if (!$vuelo->is_closed)
                    <x-slot name="actions">
                        <button class="btn btn-primary btn-danger btn-sm" wire:click="deleteTripulacionVuelo('{{$vuelo->piloto_vuelo->id}}')">
                            <i class="la la-times"></i>
                        </button>
                    </x-slot>
                    @endif
                </x-master.item>

            @else
                <div class="pb-4 text-center">
                    <div class="badge badge-error">Sin asignar</div>
                </div>
                @if (!$vuelo->is_closed)
                    <livewire:intranet.comercial.vuelo.components.input-tripulacion type="Piloto" />
                @endif
            @endif
        </div>
        <div class="p-4 bg-gray-50">
            <div class="text-center">
                <i class="text-4xl text-blue-500 las la-male"></i>
                <div>
                    <strong>Copiloto</strong>
                </div>
            </div>
            @if ($vuelo->copiloto_vuelo)
                <x-master.item class="mt-3"
                    label="{{$vuelo->copiloto_vuelo->nombre_completo}}"
                    sublabel="{{optional($vuelo->copiloto_vuelo->tripulacion)->nro_licencia}}"
                    >
                    @if (!$vuelo->is_closed)
                    <x-slot name="actions">
                        <button class="btn btn-primary btn-danger btn-sm" wire:click="deleteTripulacionVuelo('{{$vuelo->copiloto_vuelo->id}}')">
                            <i class="la la-times"></i>
                        </button>
                    </x-slot>
                    @endif
                </x-master.item>
            @else
                <div class="pb-4 text-center">
                    <div class="badge badge-error">Sin asignar</div>
                </div>
                @if (!$vuelo->is_closed)
                    <livewire:intranet.comercial.vuelo.components.input-tripulacion type="Copiloto" />
                @endif
            @endif
        </div>
    </div>
</div>
