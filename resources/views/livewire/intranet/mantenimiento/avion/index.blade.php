<div>
    @section('title', __('Avions'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Avions') }}" sublabel="Lista de Avions">
            <x-slot name="actions">
                <a href="#createAvionModal" wire:click="create" class="btn btn-primary"> <i class="la la-plus"></i>
                    Agregar</a>
            </x-slot>
        </x-master.item>
    </div>

    @include('livewire.intranet.mantenimiento.avion.create')

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Descripcion</th>
                        <th>Matricula</th>
                        <th>Modelo</th>
                        <th>Nro asientos</th>
                        {{-- <th>Tipo motor</th>
                        <th>Estado avion</th>
                        <th>Fabricante</th>
                        <th>Nro asientos</th>
                        <th>Nro pilotos</th>
                        <th>Peso max pasajeros</th>
                        <th>Peso max carga</th>
                        <th>Fecha fabricacion</th> --}}
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->descripcion }}</td>
                            <td>{{ $row->matricula }}</td>
                            <td>{{ $row->modelo }}</td>
                            <td>{{ $row->nro_asientos }}</td>
                            {{-- <td>{{ optional($row->motor)->descripcion }}</td>
                        <td>{{ optional($row->estado)->descripcion }}</td>
                        <td>{{ optional($row->fabricante)->descripcion }}</td>
                        <td>{{ $row->nro_asientos }}</td>
                        <td>{{ $row->nro_pilotos }}</td>
                        <td>{{ $row->peso_max_pasajeros }}</td>
                        <td>{{ $row->peso_max_carga }}</td>
                        <td>{{ $row->fecha_fabricacion }}</td> --}}
                            <td class="w-3">
                                <a href="{{ route('intranet.mantenimiento.avion.show', $row->id) }}"
                                    class="btn btn-circle btn-sm btn-success">
                                    <i class="la la-eye"></i>
                                </a>
                                <a href="#createAvionModal" wire:click="edit({{ $row->id }})"
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
