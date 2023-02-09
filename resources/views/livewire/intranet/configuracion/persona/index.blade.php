<div>
    @section('title', __('Personas'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Personas') }}" sublabel="Lista de Personas">
            @can('intranet.configuracion.persona.create')
                <x-slot name="actions">
                    <a href="{{ route('intranet.configuracion.persona.create') }}" class="btn btn-primary"> <i
                            class="la la-plus"></i>
                        Agregar</a>
                </x-slot>
            @endcan
        </x-master.item>
    </div>
    @include('livewire.intranet.configuracion.persona.show')

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                    <div class="grid grid-cols-3 gap-4">
                        <x-master.select wire:model="tipo_documento_id" label="Tipo Documento" :options="$tipo_documentos" />
                        <x-master.input wire:model.debounce.700ms="nro_doc" label="N° Documenbto" label="Buscar..." />
                        <x-master.input wire:model.debounce.700ms="nombre" label="Nombre" label="Buscar..." />
                    </div>
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Nombres</th>
                        <th class="text-center">Tipo documento</th>
                        <th class="text-center">Nro doc</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $row->nombre_completo }}</td>
                            <td class="text-center">{{ optional($row->tipo_documento)->descripcion }}</td>
                            <td class="text-center">{{ $row->nro_doc }}</td>
                            <td class="w-3 text-center">
                                @can('intranet.configuracion.persona.show')
                                    <a href="#showPersonaModal" wire:click="show({{ $row->id }})"
                                        class="btn btn-circle btn-sm btn-success">
                                        <i class="la la-eye"></i>
                                    </a>
                                @endcan
                                @can('intranet.configuracion.persona.edit')
                                    <a href="{{ route('intranet.configuracion.persona.edit', $row->id) }}"
                                        class="btn btn-circle btn-sm btn-warning">
                                        <i class="la la-edit"></i>
                                    </a>
                                @endcan
                                @can('intranet.configuracion.persona.delete')
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
