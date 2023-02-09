<div x-data>

    @include('livewire.intranet.comercial.descuento.components.modal-info')

    <div class="cabecera p-6">
        <x-master.item label="Lista de descuentos" sublabel="Descuentos agrupados según su tipo">
            <x-slot name="actions">
                {{-- <a href="#descuetoInfo" class="btn btn-primary btn-outline"> <i class="text-xl la la-info"></i>
                    Información
                </a> --}}
                <div class="flex items-end gap-4">
                    <div class="p-2 border-2 border-primary rounded-box">
                        @if (!$this->ruta)
                            <livewire:intranet.comercial.vuelo.components.input-ruta just-comercial />
                        @else
                            <div class="flex items-end gap-4">
                                <x-item.ruta :ruta="$this->ruta" :isSimple="true" />
                                <button class="mt-3 btn btn-primary btn-outline" wire:click="deleteRuta">
                                    <div wire:loading>
                                        @include('components.loader-horizontal-sm')
                                    </div>
                                    <div wire:loading.remove>
                                        <i class="la la-refresh"></i>
                                    </div>
                                </button>
                            </div>
                        @endif
                    </div>
                    <x-master.select label="Categorias" :options="$categorias" wire:model="categoria_descuento_id" />
                    <x-master.select label="Clasificación" :options="$clasificacions" wire:model="clasificacion_id" />
                    <x-master.select label="Estado" :options="$estados" wire:model="estado_id" />
                </div>
            </x-slot>
        </x-master.item>
    </div>
    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                    {{-- @can('intranet.comercial.descuento.resumen-mensual')
                        <a class="btn btn-success btn-outline" href="{{ route('intranet.comercial.descuento.resumen-mensual') }}">
                            <i class="text-xl la la-list"></i> &nbsp; Resumen
                        </a>
                    @endcan --}}
                    @can('intranet.comercial.descuento.create')
                        <a class="btn btn-primary" href="{{ route('intranet.comercial.descuento.create') }}">
                            <i class="text-xl la la-plus"></i> &nbsp; Nuevo
                        </a>
                    @endcan
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th style="width:50px">Desc</th>
                        <th>Ruta</th>
                        <th>Tipo</th>
                        <th>PAX</th>
                        <th>Descuento</th>
                        <th>Fecha exp.</th>
                        <th>Nro máximo por vuelo</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="width:50px">{{ $row->descripcion }}</td>
                            <td>
                                @if ($row->ruta_id)
                                    <div class="flex items-center">
                                        <div>
                                            <span>{{ optional(optional($row->ruta->tramo)->origen)->distrito }}</span>
                                            <br>
                                            <span>{{ optional(optional($row->ruta->tramo)->destino)->distrito }}</span>
                                        </div>
                                        <div>
                                            <i class="la la-arrow-down"></i>
                                        </div>
                                    </div>
                                    @include('livewire.intranet.components.badge-tipo-vuelo', [
                                        'tipo_vuelo' => $row->ruta->tipo_vuelo,
                                    ])
                                @endif
                            </td>
                            <td>{{ optional($row->categoria_descuento)->descripcion }}</td>
                            <td>{{ optional($row->tipo_pasaje)->abreviatura }}</td>
                            <td>
                                @switch(optional($row->categoria_descuento)->descripcion)
                                    @case('Porcentaje')
                                        <div class="badge">
                                            - @nro($row->descuento_porcentaje) %
                                        </div>
                                    @break

                                    @case('Monto restado')
                                        @if ($row->is_dolarizado)
                                            <div class="badge">
                                                - @dolares($row->descuento_monto)
                                            </div>
                                            <br>
                                            ≈ @toSoles($row->descuento_monto_soles)
                                        @else
                                            <div class="badge">
                                                - @soles($row->descuento_monto)
                                            </div>
                                        @endif
                                    @break

                                    @default
                                        @if ($row->is_dolarizado)
                                            <div class="badge">
                                                @dolares($row->descuento_fijo)
                                            </div>
                                            <br>
                                            ≈ @soles($row->descuento_fijo_soles)
                                        @else
                                            <div class="badge">
                                                @soles($row->descuento_fijo)
                                            </div>
                                        @endif
                                @endswitch
                            </td>
                            <td>{{ optional($row->fecha_expiracion)->format('Y-m-d') }}</td>
                            <td>
                                @if ($row->nro_maximo)
                                    {{$row->nro_maximo}}
                                @endif
                            </td>
                            <td>
                                <div class="badge {{ $row->badge_state }}">{{ $row->state }}</div>
                            </td>
                            <td class="w-3">
                                @if (!$row->trashed())
                                    @can('intranet.comercial.descuento.edit')
                                        <a href="{{ route('intranet.comercial.descuento.edit', $row->id) }}"
                                            class="btn btn-circle btn-sm btn-warning">
                                            <i class="la la-edit"></i>
                                        </a>
                                    @endcan
                                    @can('intranet.comercial.descuento.delete')
                                        <button wire:click="destroy({{ $row->id }})"
                                            class="btn btn-circle btn-sm btn-danger"
                                            onclick="confirm('¿Está seguro de eliminar? No podrá recuperarlo después')||event.stopImmediatePropagation()">
                                            <i class="la la-trash"></i>
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
