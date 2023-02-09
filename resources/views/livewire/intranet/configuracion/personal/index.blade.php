<div>
    @section('title', __('Personals'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Personals') }}" sublabel="Lista de Personals">
            @can('intranet.configuracion.personal.create')
                <x-slot name="actions">
                    <a href="{{ route('intranet.configuracion.personal.create') }}" wire:click="create" class="btn btn-primary"> <i class="la la-plus"></i>
                        Agregar</a>
                </x-slot>
            @endcan
        </x-master.item>
    </div>
    @include('livewire.intranet.configuracion.personal.show')

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Oficina</th>
                        <th>Persona</th>
                        <th>Fecha ingreso</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($row->oficina)->descripcion }}</td>
                            <td>{{ optional($row->persona)->nombre_completo }}</td>
                            <td>{{ optional($row->fecha_ingreso)->format('Y-m-d') }}</td>
                            <td class="w-3">
                                @can('intranet.configuracion.personal.show')
                                    <a href="#showPersonalModal" wire:click="show({{ $row->id }})"
                                        class="btn btn-circle btn-sm btn-success">
                                        <i class="la la-eye"></i>
                                    </a>
                                @endcan
                                @can('intranet.configuracion.personal.edit')
                                    <a href="{{route('intranet.configuracion.personal.edit', $row->id)}}"
                                        class="btn btn-circle btn-sm btn-warning">
                                        <i class="la la-edit"></i>
                                    </a>
                                @endcan
                                @can('intranet.configuracion.personal.delete')
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
