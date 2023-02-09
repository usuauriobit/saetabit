<div>
    <x-master.item label="Pasajeros">
        <x-slot name="sublabel">
            Lista de pasajeros que aparecen en esta ruta.
        </x-slot>
        <x-slot name="avatar">
            <i class="las la-users"></i>
        </x-slot>
        <x-slot name="actions">
            <button wire:loading.attr="disabled" class="btn btn-info" wire:click="refreshPasajeros">
                <i class="la la-refresh"></i>
            </button>
            @if (!$vuelo->is_closed)
                <a
                    href="{{ route('intranet.comercial.adquisicion-pasaje.create',
                        [
                            'alreadySetType' => 'vuelo',
                            'alreadySetId' => $vuelo->id
                        ]) }}"
                    class="btn btn-primary">
                    Registrar pasajero
                </a>
            @endif
        </x-slot>
    </x-master.item>
    @foreach ($vuelo->pasajes as $pasaje)
        <livewire:intranet.components.modal-password-validation
            wire:key="ModalPasswordValidation{{$pasaje->id}}"
            eventName="anularPasajeConfirmated"
            withObservacion
            modalName="modalAnularPasaje{{ $pasaje->id }}"
            eventId="{{ $pasaje->id }}" />
    @endforeach
    <div class="h-full ">
        <table class="table w-full mt-3 table-striped table-responsive">
            <thead>
                <tr>
                    <th>COD</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th></th>
                    <th>Equipaje</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $vueloAnterior = $vuelo->vuelo_anterior;
                    $vueloSiguiente = $vuelo->vuelo_siguiente;
                @endphp
                @foreach ($vuelo->pasajes as $pasaje)
                <tr>
                    <td class="text-xs">{{ $pasaje->codigo }}</td>
                    <td>{{ $pasaje->nombre_short }}</td>
                    <td>{{ optional($pasaje->tipo_pasaje)->abreviatura }}</td>
                    <td>
                        @if ($vueloAnterior && $pasaje->hasVuelo($vueloAnterior->id))
                            <div class="badge badge-info">
                                Desde vuelo anterior
                            </div>
                        @endif
                        @if ($vueloSiguiente && $pasaje->hasVuelo($vueloSiguiente->id))
                            <div class="badge badge-info">
                                Hasta siguiente vuelo
                            </div>
                        @endif
                    </td>
                    <td>
                        <livewire:intranet.comercial.pasaje.components.item-equipajes
                            wire:key={{now()}}
                            :pasaje="$pasaje"
                            :vuelo="$vuelo"
                        />
                    </td>
                    <td>
                        @include('livewire.intranet.comercial.vuelo.components.status-pasajero')
                    </td>
                    <td>
                        <livewire:intranet.comercial.pasaje.components.action-options wire:key="tr{{$pasaje->id}}" :pasaje="$pasaje" :vuelo="$vuelo" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
