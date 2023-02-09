<div>
    @section('title', __('Cuenta bancaria referencial'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Cuenta bancaria referencial') }}"
            sublabel="Lista de Cuentas bancarias referenciales">
            <x-slot name="actions">
                <a href="#createCuentaBancariaReferencialModal" wire:click="create" class="btn btn-primary"> <i
                        class="la la-plus"></i> Agregar</a>
            </x-slot>
        </x-master.item>
    </div>
    @include('livewire.intranet.configuracion.cuenta-bancaria-referencial.create')
    @include('livewire.intranet.configuracion.cuenta-bancaria-referencial.show')

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Nro cuenta</th>
                        <th>Descripcion cuenta</th>
                        <th>Glosa</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->nro_cuenta }}</td>
                            <td>{{ $row->descripcion_cuenta }}</td>
                            <td>{{ $row->glosa }}</td>
                            <td class="w-3">
                                <a href="#showCuentaBancariaReferencialModal" wire:click="show({{ $row->id }})"
                                    class="btn btn-circle btn-sm btn-success">
                                    <i class="la la-eye"></i>
                                </a>
                                <a href="#createCuentaBancariaReferencialModal" wire:click="edit({{ $row->id }})"
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
