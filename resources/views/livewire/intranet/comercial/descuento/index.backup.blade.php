<div x-data>

    @include('livewire.intranet.comercial.descuento.components.modal-info')

    <div class="cabecera p-6">
        <x-master.item label="Lista de descuentos" sublabel="Descuentos agrupados según su tipo">
            <x-slot name="actions">
                <a href="#descuetoInfo" class="btn btn-primary btn-outline"> <i class="text-xl la la-info"></i>
                    Información
                </a>
                {{-- <a href="#createOficinaModal" wire:click="create" class="btn btn-primary"> <i class="la la-plus"></i>
                    Agregar</a> --}}
            </x-slot>
        </x-master.item>
    </div>

    <div class="mb-4 tabs tabs-boxed">
        <a class="tab" :class="{ 'tab-active': $wire.tab == 'codigo_cupon' }"
            @click="$wire.setTab('codigo_cupon')">Por código de cupón</a>
        <a class="tab" :class="{ 'tab-active': $wire.tab == 'ida_vuelta' }" @click="$wire.setTab('ida_vuelta')">Por
            ida y vuelta</a>
        <a class="tab" :class="{ 'tab-active': $wire.tab == 'ruta' }" @click="$wire.setTab('ruta')">Por Ruta</a>
        <a class="tab" :class="{ 'tab-active': $wire.tab == 'pasaje' }" @click="$wire.setTab('pasaje')">Por
            pasaje</a>
        <a class="tab" :class="{ 'tab-active': $wire.tab == 'interno' }"
            @click="$wire.setTab('interno')">Interno</a>
        <a class="tab" wire:loading>
            @include('components.loader-horizontal-sm')
        </a>
    </div>

    <div>
        <x-master.datatable :items="$items">
            <x-slot name="actions">
                @can('intranet.comercial.descuento.create')
                    <a class="btn btn-primary" href="{{ route('intranet.comercial.descuento.create', ['type' => $tab]) }}">
                        <i class="text-xl la la-plus"></i> &nbsp; Nuevo
                    </a>
                @endcan
            </x-slot>
            <x-slot name="thead">
                <tr>
                    <th>#</th>
                    <th>Tipo descuento</th>
                    <th style="width:50px">Desc</th>
                    <th>Ruta</th>
                    <th>Descuento</th>
                    <th>Exp.</th>
                    <th>Codigo</th>
                    <th>Nro</th>
                    <th>Nro disp.</th>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="tbody">
                @foreach ($items as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ optional($row->tipo_descuento)->descripcion }}</td>
                        <td style="width:50px">{{ $row->descripcion }}</td>
                        <td>
                            @if ($row->ruta_id)
                                <x-item.ruta :ruta="$row->ruta"></x-item.ruta>
                            @endif
                        </td>
                        <td>
                            @if ($row->is_porcentaje)
                                {{ $row->descuento_porcentaje }} %
                            @else
                                @soles($row->descuento_monto)
                            @endif
                        </td>
                        <td>
                            @if ($row->fecha_expiracion)
                                <div class="badge {{ $row->is_expirado }}">
                                    {{ $row->fecha_expiracion->format('Y-m-d') }}
                                </div>
                            @endif
                        </td>
                        <td>{{ $row->codigo_cupon }}</td>
                        <td>{{ $row->nro_maximo }}</td>
                        <td>{{ $row->cantidad_disponible }}</td>
                        <td class="w-3">
                            {{-- <a href="#showOficinaModal" wire:click="show({{ $row->id }})"
                                class="btn btn-circle btn-sm btn-success">
                                <i class="la la-eye"></i>
                            </a> --}}
                            @if ($row->trashed())
                                <div class="badge badge-danger">Eliminado</div>
                            @else
                                @can('intranet.comercial.descuento.edit')
                                    <a href="#createOficinaModal" wire:click="edit({{ $row->id }})"
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

    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
</div>
