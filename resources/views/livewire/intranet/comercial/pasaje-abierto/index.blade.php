<div>
    @section('title', __('Pasajes abiertos'))
    <div class="cabecera p-6">
        <x-master.item label="Pasajes abiertos"
            sublabel="{{ $nro_pasajes_abiertos_pendientes }} pasajes con estado abierto">
            <x-slot name="actions">
                <div class="grid grid-cols-3 gap-4">
                    <x-master.input label="Origen" name="origen" wire:model.debounce.700ms="origen"></x-master.input>
                    <x-master.input label="Destino" name="destino" wire:model.debounce.700ms="destino"></x-master.input>
                    <x-master.select label="Estado" placeholder="Estado" name="state" wire:model.debounce.700ms="state" :options="$states"></x-master.select>
                </div>
            </x-slot>
        </x-master.item>
        {{-- <div>
            <div class="w-60">
                <x-master.select label="Filtrar por estado" :options="$estado_options">
                </x-master.select>
            </div>
        </div> --}}
    </div>
    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                    <div class="grid grid-cols-4 gap-4">
                        <x-master.input label="Desde" name="desde" wire:model="desde" type="date"></x-master.input>
                        <x-master.input label="Hasta" name="hasta" wire:model="hasta" type="date"></x-master.input>
                        <x-master.input label="N° Documento" name="search" wire:model.debounce.700ms="nro_documento"></x-master.input>
                        <x-master.input label="Nombre" placeholder="Buscar ..." name="search" wire:model.debounce.700ms="search"></x-master.input>
                    </div>
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th>COD</th>
                        <th>Fecha adq.</th>
                        <th>N° Doc</th>
                        <th>Pasajero</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $pasaje)
                        <tr>
                            <td>{{ $pasaje->codigo }}</td>
                            <td>
                                <small>
                                    {{ optional($pasaje->created_at)->format('Y-m-d') }} <br>
                                    {{ optional($pasaje->created_at)->format('g:i a') }}
                                </small>
                            </td>
                            <td>{{ $pasaje->pasajero->nro_doc }}</td>
                            <td>{{ $pasaje->pasajero->nombre_short }}</td>
                            <td>
                                <x-item.ubicacion :ubicacion="$pasaje->get_origen">
                                    @if ($pasaje->vuelo_origen)
                                        <x-master.item label="Horario de despegue"
                                            sublabel="{{ optional(optional($pasaje->vuelo_origen)->fecha_hora_vuelo_programado)->format('Y-m-d g:ia') }}" />
                                    @endif
                                </x-item.ubicacion>
                            </td>
                            <td>
                                <x-item.ubicacion :ubicacion="$pasaje->get_destino">
                                    @if ($pasaje->vuelo_destino)
                                        <x-master.item label="Horario de aterrizaje"
                                            sublabel="{{ optional(optional($pasaje->vuelo_destino)->fecha_hora_aterrizaje_programado)->format('Y-m-d g:ia') }}" />
                                    @endif
                                </x-item.ubicacion>
                            </td>
                            <td>
                                @include('livewire.intranet.comercial.pasaje.components.status')
                            </td>
                            <td>
                                <a class="btn btn-outline btn-sm btn-success"
                                    href="{{ route('intranet.comercial.pasaje.show', $pasaje) }}">
                                    <i class="la la-eye"></i>
                                </a>
                                @if ($pasaje->can_export_boarding_pass)
                                    <a target="_blank"
                                        href="{{ route('intranet.comercial.pasaje.export.boarding-pass', $pasaje) }}"
                                        class="btn btn-outline btn-sm btn-warning">
                                        <i class="la la-file"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
