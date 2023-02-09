<div>
    @section('title', __('Categoria vuelos'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Categoria vuelos') }}" sublabel="Lista de Categoria vuelos">
            @can('intranet.configuracion.categoria-vuelo.create')
                <x-slot name="actions">
                    <a href="#createCategoriaVueloModal" wire:click="create" class="btn btn-primary">
                        <i class="la la-plus"></i> Agregar
                    </a>
                </x-slot>
            @endcan
        </x-master.item>
    </div>
    @include('livewire.intranet.configuracion.categoria_vuelo.create')
    @include('livewire.intranet.configuracion.categoria_vuelo.show')

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Descripcion</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->descripcion }}</td>
                            <td class="w-3">
                                @can('intranet.configuracion.categoria-vuelo.show')
                                    <a href="#showCategoriaVueloModal" wire:click="show({{ $row->id }})"
                                        class="btn btn-circle btn-sm btn-success">
                                        <i class="la la-eye"></i>
                                    </a>
                                @endcan
                                @can('intranet.configuracion.categoria-vuelo.edit')
                                    <a href="#createCategoriaVueloModal" wire:click="edit({{ $row->id }})"
                                        class="btn btn-circle btn-sm btn-warning">
                                        <i class="la la-edit"></i>
                                    </a>
                                @endcan
                                @can('intranet.configuracion.categoria-vuelo.delete')
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
