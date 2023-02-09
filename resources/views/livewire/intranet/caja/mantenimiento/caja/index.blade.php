<div>
    @section('title', __('Cajas'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Cajas') }}" sublabel="Lista de Cajas">
            <x-slot name="actions">
                @can('intranet.caja.mantenimiento.caja.create')
                    <a href="#createCajaModal" wire:click="create" class="btn btn-primary">
                        <i class="la la-plus"></i>Agregar
                    </a>
                @endcan
            </x-slot>
        </x-master.item>
    </div>
    @include('livewire.intranet.caja.mantenimiento.caja.create')

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Serie</th>
                        <th>Descripcion</th>
                        <th>Oficina</th>
                        <th>Cajeros</th>
                        <th>Tipo caja</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->serie }}</td>
                            <td>{{ $row->descripcion }}</td>
                            <td>{{ optional($row->oficina)->descripcion }}</td>
                            <td>{{ $row->cajeros->implode('nombre_completo', ', ') ?? null }}</td>
                            <td>{{ optional($row->tipo_caja)->descripcion }}</td>
                            <td class="w-3">
                                @can('intranet.caja.mantenimiento.caja.show')
                                    <a href="{{ route('intranet.caja.mantenimiento.caja.show', $row) }}"
                                        class="btn btn-circle btn-sm btn-success">
                                        <i class="la la-eye"></i>
                                    </a>
                                @endcan
                                @can('intranet.caja.mantenimiento.caja.edit')
                                    <a href="#createCajaModal" wire:click="edit({{ $row->id }})"
                                        class="btn btn-circle btn-sm btn-warning">
                                        <i class="la la-edit"></i>
                                    </a>
                                @endcan
                                @can('intranet.caja.mantenimiento.caja.delete')
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
