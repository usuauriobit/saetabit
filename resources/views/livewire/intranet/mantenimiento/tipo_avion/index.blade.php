<div>
    @section('title', __('Tipo avions'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Tipo avions') }}" sublabel="Lista de Tipo avions">
            <x-slot name="actions">
                <a href="#createTipoAvionModal" wire:click="create" class="btn btn-primary"> <i class="la la-plus"></i>
                    Agregar</a>
            </x-slot>
        </x-master.item>
    </div>
    @include('livewire.intranet.mantenimiento.tipo_avion.create')
    @include('livewire.intranet.mantenimiento.tipo_avion.show')

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
                                <a href="#showTipoAvionModal" wire:click="show({{ $row->id }})"
                                    class="btn btn-circle btn-sm btn-success">
                                    <i class="la la-eye"></i>
                                </a>
                                <a href="#createTipoAvionModal" wire:click="edit({{ $row->id }})"
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
