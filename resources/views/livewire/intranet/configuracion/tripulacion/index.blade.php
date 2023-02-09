<div>
    @section('title', __('Tripulacions'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Tripulacions') }}" sublabel="Lista de Tripulacions">
            <x-slot name="actions">
                <a href="#createTripulacionModal" wire:click="create" class="btn btn-primary"> <i class="la la-plus"></i>
                    Agregar</a>
            </x-slot>
        </x-master.item>
    </div>
    @include('livewire.intranet.configuracion.tripulacion.create')
    @include('livewire.intranet.configuracion.tripulacion.show')

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Persona</th>
                        <th>Tipo tripulacion</th>
                        <th>Nro licencia</th>
                        <th>Fecha vencimiento licencia</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($row->persona)->nombre_completo }}</td>
                            <td>{{ optional($row->tipo_tripulacion)->descripcion }}</td>
                            <td>{{ $row->nro_licencia }}</td>
                            <td>{{ optional($row->fecha_vencimiento_licencia)->format('Y-m-d') }}
                            </td>
                            <td class="w-3">
                                <a href="#showTripulacionModal" wire:click="show({{ $row->id }})"
                                    class="btn btn-circle btn-sm btn-success">
                                    <i class="la la-eye"></i>
                                </a>
                                <a href="#createTripulacionModal" wire:click="edit({{ $row->id }})"
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
