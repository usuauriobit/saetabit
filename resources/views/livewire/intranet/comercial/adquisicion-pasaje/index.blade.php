<div>
    @section('title', __('Adquisición de pasajes'))
    <div class="cabecera p-6">
        <x-master.item label="Adquisición de pasajes" sublabel="Historial de pasajes adquiridos">
            <x-slot name="actions">
                <div class="grid grid-cols-4 items-end gap-4">
                    <x-master.input label="Origen" placeholder="Origen" name="origen" wire:model.debounce.700ms="origen"></x-master.input>
                    <x-master.input label="Destino" placeholder="Destino" name="destino" wire:model.debounce.700ms="destino"></x-master.input>
                    <x-master.select wire:model="filterSelected" label="Filtrar por" :options="$filterOptions" />
                    @can('intranet.comercial.pasaje.create')
                        <a href="{{ route('intranet.comercial.adquisicion-pasaje.create') }}" class="btn btn-primary"> <i
                                class="la la-plus"></i> Agregar</a>
                    @endcan
                </div>
            </x-slot>
        </x-master.item>
    </div>
    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                    <div class="grid grid-cols-3 items-end gap-4">
                        <x-master.input label="Desde" type="date" name="desde" wire:model="desde"></x-master.input>
                        <x-master.input label="Hasta" type="date" name="hasta" wire:model="hasta"></x-master.input>
                        <x-master.input label="Nombre" placeholder="Buscar ..." name="search" wire:model.debounce.700ms="search"></x-master.input>
                    </div>
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>COD</th>
                        <th>Nombre</th>
                        <th>Tipo vuelo</th>
                        <th>Tipo</th>
                        {{-- <th>Telefono</th> --}}
                        <th>Fecha</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><small>{{ $row->codigo }}</small></td>
                            <td>{{ $row->pasajero->nombre_short }}</td>
                            <td>{{ optional($row->tipo_vuelo)->descripcion }}</td>
                            <td>
                                @include('livewire.intranet.comercial.adquisicion-pasaje.components.item-tipo-pasaje',
                                    ['pasaje' => $row])
                            </td>
                            {{-- <td>{{$row->telefono}}</td> --}}
                            <td>{{ optional($row->fecha)->format('Y-m-d') }}</td>
                            <td>
                                <strong class="text-grey-500">{{ optional($row->origen)->codigo_default }}</strong> <br>
                                {{ optional($row->origen)->distrito }}
                            </td>
                            <td>
                                <strong class="text-grey-500">{{ optional($row->destino)->codigo_default }}</strong>
                                <br>
                                {{ optional($row->destino)->distrito }}
                            </td>
                            <td>
                                @include('livewire.intranet.comercial.pasaje.components.status', [
                                    'pasaje' => $row,
                                ])
                            </td>
                            <td class="w-3">
                                @can('intranet.comercial.pasaje.show')
                                    <a href="{{ route('intranet.comercial.pasaje.show', $row) }}"
                                        class="btn btn-circle btn-sm btn-success">
                                        <i class="la la-eye"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
