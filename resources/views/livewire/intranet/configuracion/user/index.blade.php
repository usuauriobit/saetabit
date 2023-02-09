<div>
    @section('title', __('Usuarios'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Usuarios') }}" sublabel="Lista de usuarios">
            <x-slot name="actions">
                <a href="#createOficinaModal" wire:click="create" class="btn btn-primary"> <i class="la la-plus"></i>
                    Agregar</a>
            </x-slot>
        </x-master.item>
    </div>
    @include('livewire.intranet.configuracion.user.create')
    @include('livewire.intranet.configuracion.user.show')

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Img</th>
                        <th>Nombre</th>
                        <th>Oficina</th>
                        <th>Email</th>
                        <th>Rol</th>
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
                                        <img src="{{ $row->profile_photo_url }}" alt="" srcset="">
                                    </div>
                                </div>
                            </td>
                            <td>{{ $row->name }}</td>
                            <td>{{ optional(optional($row->personal)->oficina)->descripcion }}</td>
                            <td>{{ $row->email }}</td>
                            <td>
                                @foreach ($row->roles as $rol)
                                    <div class="badge badge-info">{{ $rol->name }}</div>
                                @endforeach
                            </td>
                            <td class="w-3">
                                <a href="#showOficinaModal" wire:click="show({{ $row->id }})"
                                    class="btn btn-circle btn-sm btn-success">
                                    <i class="la la-eye"></i>
                                </a>
                                <a href="#createOficinaModal" wire:click="edit({{ $row->id }})"
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
