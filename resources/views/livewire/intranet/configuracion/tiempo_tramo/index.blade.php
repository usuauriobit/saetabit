<div>
    @section('title', __('Tiempo tramos'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Tiempo tramos') }}" sublabel="Lista de Tiempo tramos">
            @can('intranet.configuracion.tiempo-tramo.create')
                <x-slot name="actions">
                    <a href="#createTiempoTramoModal" wire:click="create" class="btn btn-primary"> <i class="la la-plus"></i>
                        Agregar</a>
                </x-slot>
            @endcan
        </x-master.item>
    </div>
    @include('livewire.intranet.configuracion.tiempo_tramo.create')
    @include('livewire.intranet.configuracion.tiempo_tramo.show')

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Tramo</th>
                        <th>Avion</th>
                        <th>Tiempo vuelo</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($row->tramo)->descripcion }}</td>
                            <td>{{ optional($row->avion)->descripcion }}</td>
                            <td>{{ $row->tiempo_vuelo }}</td>
                            <td class="w-3">
                                @can('intranet.configuracion.tiempo-tramo.show')
                                    <a href="#showTiempoTramoModal" wire:click="show({{ $row->id }})"
                                        class="btn btn-circle btn-sm btn-success">
                                        <i class="la la-eye"></i>
                                    </a>
                                @endcan
                                @can('intranet.configuracion.tiempo-tramo.edit')
                                    <a href="#createTiempoTramoModal" wire:click="edit({{ $row->id }})"
                                        class="btn btn-circle btn-sm btn-warning">
                                        <i class="la la-edit"></i>
                                    </a>
                                @endcan
                                @can('intranet.configuracion.tiempo-tramo.delete')
                                    <button wire:click="destroy({{ $row->id }})"
                                        class="btn btn-circle btn-sm btn-danger"
                                        onclick="confirm('¿Está seguro de eliminar? No podrá recuperarlo después')||event.stopImmediatePropagation()">
                                        <i class="la la-trash"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
