<div>
    @section('title', __('Tipo vuelos'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Tipo vuelos') }}" sublabel="Lista de Tipo vuelos">
            <x-slot name="actions">
                @can('intranet.configuracion.tipo-vuelo.create')
                    <a href="#createTipoVueloModal" wire:click="create" class="btn btn-primary"> <i class="la la-plus"></i>
                        Agregar</a>
                @endcan
            </x-slot>
        </x-master.item>
    </div>
    @include('livewire.intranet.configuracion.tipo_vuelo.create')
    @include('livewire.intranet.configuracion.tipo_vuelo.show')

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Categoria vuelo</th>
                        <th>Descripcion</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($row->categoria_vuelo)->descripcion }}</td>
                            <td>{{ $row->descripcion }}</td>
                            <td class="w-3">
                                <a href="#showTipoVueloModal" wire:click="show({{ $row->id }})"
                                    class="btn btn-circle btn-sm btn-success">
                                    <i class="la la-eye"></i>
                                </a>
                                <a href="#createTipoVueloModal" wire:click="edit({{ $row->id }})"
                                    class="btn btn-circle btn-sm btn-warning">
                                    <i class="la la-edit"></i>
                                </a>
                                <button wire:click="destroy({{ $row->id }})"
                                    class="btn btn-circle btn-sm btn-danger"
                                    onclick="confirm('¿Está seguro de eliminar? No podrá recuperarlo después')||event.stopImmediatePropagation()">
                                    <i class="la la-trash"></i>
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
