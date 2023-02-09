<div>
    @section('title', __('Cambios de pasajes'))
    <div class="cabecera p-6">
        <x-master.item label="Cambios de pasajes" sublabel="{{ $nro_pendientes }} pendientes de confirmación">
            <x-slot name="actions">
            </x-slot>
        </x-master.item>
    </div>
    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                    <div class="grid grid-cols-5 items-end gap-4">
                        <x-master.input label="N° Documento" placeholder="" name="nro_documento" wire:model.debounce.700ms="nro_documento"></x-master.input>
                        <x-master.input label="Desde" name="desde" type="date" wire:model="desde"></x-master.input>
                        <x-master.input label="Hasta" name="hasta" type="date" wire:model="hasta"></x-master.input>
                        <x-master.select label="Filtrar por estado" :options="$estado_options"></x-master.select>
                        <x-master.input placeholder="Buscar ..." name="search" wire:model.debounce.700ms="search"></x-master.input>
                    </div>
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">COD Pasaje</th>
                        <th class="text-center">Tipo Pasaje</th>
                        <th class="text-center">Tipo Cambio</th>
                        {{-- <th class="text-center">Tipo Doc</th> --}}
                        <th class="text-center">N° Doc</th>
                        <th class="text-center">Pasajero</th>
                        <th class="text-center">Registrado por</th>
                        <th class="text-center">Fecha registro</th>
                        <th class="text-center">Nota</th>
                        <th class="text-center">Estado</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center"><small>{{ $row->pasaje->codigo }}</small></td>
                            <td class="text-center">
                                @include('livewire.intranet.comercial.adquisicion-pasaje.components.item-tipo-pasaje',
                                    ['pasaje' => $row->pasaje])
                            </td>
                            <td>{{ optional($row->tipo_pasaje_cambio)->descripcion }}</td>
                            {{-- <td class="text-center">{{ optional($row->pasajero_nuevo)->tipo_documento->descripcion }}</td> --}}
                            <td class="text-center">{{ optional($row->pasajero_nuevo)->nro_doc }}</td>
                            <td>
                                @include('livewire.intranet.comercial.pasaje-cambio.components.pasajero')
                            </td>
                            <td>{{ optional($row->user_created)->username }}</td>
                            <td class="text-center">{{ optional($row->created_at)->format('Y-m-d g:i a') }}</td>
                            <td>{{ $row->nota }}</td>
                            <td class="text-center">
                                @include('livewire.intranet.comercial.pasaje-cambio.components.badge-status',
                                    ['cambio' => $row])
                            </td>
                            <td class="text-center">
                                @if (!$row->is_confirmado && !$row->trashed())
                                    @can('intranet.comercial.pasaje-cambio.confirmar')
                                        <button class="btn btn-success" wire:click="confirmar({{ $row->id }})"
                                            onclick="confirm('¿Está seguro de confirmar?')||event.stopImmediatePropagation()">
                                            <i class="la la-check"></i> Confirmar
                                        </button>
                                    @endcan
                                    @can('intranet.comercial.pasaje-cambio.denegar')
                                        <button class="btn btn-danger" wire:click="denegar({{ $row->id }})"
                                            onclick="confirm('¿Está seguro de denegar?')||event.stopImmediatePropagation()">
                                            <i class="la la-close"></i> Denegar
                                        </button>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
