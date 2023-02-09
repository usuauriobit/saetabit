<div>
    @section('title', __('Oficinas'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Oficinas') }}" sublabel="Lista de Oficinas">
            @can('intranet.configuracion.oficina.create')
                <x-slot name="actions">
                    <a href="#createOficinaModal" wire:click="create" class="btn btn-primary"> <i class="la la-plus"></i>
                        Agregar</a>
                </x-slot>
            @endcan
        </x-master.item>
    </div>
    @include('livewire.intranet.configuracion.oficina.create')
    @include('livewire.intranet.configuracion.oficina.show')

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Img</th>
                        <th>Ubigeo</th>
                        <th>Geo latitud</th>
                        <th>Geo longitud</th>
                        <th>Descripcion</th>
                        <th>Direccion</th>
                        <th>Referencia</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="avatar">
                                    <div class="w-10 h-10 rounded-full">
                                        <img src="{{ $row->image_url }}">
                                    </div>
                                </div>
                            </td>
                            <td>{{ optional($row->ubigeo)->descripcion }}</td>
                            <td>{{ $row->geo_latitud }}</td>
                            <td>{{ $row->geo_longitud }}</td>
                            <td>{{ $row->descripcion }}</td>
                            <td>{{ $row->direccion }}</td>
                            <td>{{ $row->referencia }}</td>
                            <td class="w-3">
                                @can('intranet.configuracion.oficina.show')
                                    <a href="#showOficinaModal" wire:click="show({{ $row->id }})"
                                        class="btn btn-circle btn-sm btn-success">
                                        <i class="la la-eye"></i>
                                    </a>
                                @endcan
                                @can('intranet.configuracion.oficina.edit')
                                    <a href="#createOficinaModal" wire:click="edit({{ $row->id }})"
                                        class="btn btn-circle btn-sm btn-warning">
                                        <i class="la la-edit"></i>
                                    </a>
                                @endcan
                                @can('intranet.configuracion.oficina.delete')
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
