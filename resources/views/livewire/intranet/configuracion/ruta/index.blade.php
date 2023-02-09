<div>
    @section('title', __('Rutas'))
    <div class="pt-6">
        <x-master.item label="{{ ucfirst('Rutas') }}" sublabel="Lista de Rutas">
            @can('intranet.configuracion.ruta.create')
                <x-slot name="actions">
                    <a href="#createRutaModal" wire:click="create" class="btn btn-primary"> <i class="la la-plus"></i>
                        Agregar</a>
                </x-slot>
            @endcan
        </x-master.item>
    </div>
    <div class="my-2 alert alert-info">
        <div class="flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <label>
                Los registros que ya se encuentren relacionados con datos de
                <strong>Tarifas</strong>
                no podrán ser eliminados.
            </label>
        </div>
    </div>

    @include('livewire.intranet.configuracion.ruta.create')
    @include('livewire.intranet.configuracion.ruta.show')

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                    <div class="grid grid-cols-3 gap-4">
                        <x-master.select wire:model="tipo_vuelo_id" label="Tipo Vuelo" :options="$tipo_vuelos" />
                        <x-master.input wire:model.debounce.700ms="search_origen" label="Origen" placeholder="Buscar..." />
                        <x-master.input wire:model.debounce.700ms="search_destino" label="Destino" placeholder="Buscar..." />
                    </div>
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Tipo vuelo</th>
                        <th>Tramo</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="badge badge-primary" style="background: {{ $colores[optional($row->tipo_vuelo)->descripcion] ?? '#34ebc9' }}">
                                {{ optional($row->tipo_vuelo)->descripcion }}
                            </div>
                        </td>
                        <td>
                            <x-item.ruta :ruta="$row"/>
                        </td>
                        <td class="w-3">
                            @can('intranet.configuracion.ruta.show')
                                <a href="#showRutaModal" wire:click="show({{$row->id}})"
                                    class="btn btn-circle btn-sm btn-success">
                                    <i class="la la-eye"></i>
                                </a>
                            @endcan
                            {{-- <a href="#createRutaModal" wire:click="edit({{$row->id}})"
                                class="btn btn-circle btn-sm btn-warning">
                                <i class="la la-edit"></i>
                            </a> --}}
                            @can('intranet.configuracion.ruta.delete')
                                @if ($row->tarifas->count() == 0)
                                    <button wire:click="destroy({{$row->id}})" class="btn btn-circle btn-sm btn-danger"
                                        onclick="confirm('¿Está seguro de eliminar? No podrá recuperarlo después')||event.stopImmediatePropagation()">
                                        <i class="la la-trash"></i>
                                    </button>
                                @endif
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
