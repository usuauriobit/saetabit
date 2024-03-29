<div>
    @section('title', __('Ubicacions'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Ubicacions') }}" sublabel="Lista de Ubicacions">
            <x-slot name="actions">
                <a href="#createUbicacionModal" wire:click="create" class="btn btn-primary"> <i class="la la-plus"></i>
                    Agregar</a>
            </x-slot>
        </x-master.item>
    </div>
    @include('livewire.intranet.mantenimiento.ubicacion.create')
    @include('livewire.intranet.mantenimiento.ubicacion.show')

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Ubigeo</th>
                        <th>Tipo pista</th>
                        <th>Codigo icao</th>
                        <th>Codigo iata</th>
                        <th>Descripcion</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($row->ubigeo)->descripcion }}</td>
                            <td>{{ optional($row->tipo_pista)->descripcion }}</td>
                            <td>{{ $row->codigo_icao }}</td>
                            <td>{{ $row->codigo_iata }}</td>
                            <td>{{ $row->descripcion }}</td>
                            <td class="w-3">
                                <a href="#showUbicacionModal" wire:click="show({{ $row->id }})"
                                    class="btn btn-circle btn-sm btn-success">
                                    <i class="la la-eye"></i>
                                </a>
                                <a href="#createUbicacionModal" wire:click="edit({{ $row->id }})"
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
