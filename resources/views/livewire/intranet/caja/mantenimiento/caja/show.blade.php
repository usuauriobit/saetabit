<div>
    <x-master.item label="Caja" class="col-span-3 my-4">
        <x-slot name="sublabel">
            Caja: {{ $caja->descripcion }}
        </x-slot>
        <x-slot name="actions">
            @can('intranet.caja.mantenimiento.caja.comprobante.create')
                <a href="#addComprobante" wire:click="create()" class="btn btn-success btn-sm">Agregar Comprobante</a>
            @endcan
            @can('intranet.caja.mantenimiento.caja.cajero.create')
                <a href="#addCajeros" wire:click="create()" class="btn btn-warning btn-sm">Asignar Cajeros</a>
            @endcan
            <a class="btn btn-primary btn-sm" href="{{ route('intranet.caja.mantenimiento.caja.index') }}">Volver</a>
        </x-slot>
    </x-master.item>
    @include('livewire.intranet.caja.mantenimiento.caja.components.add-cajeros')
    @include('livewire.intranet.caja.mantenimiento.caja.components.add-comprobante')
    <div class="card card-white">
        <div class="card-body">
            <div class="grid grid-cols-5 gap-4">
                <x-master.item class="mb-4" label="Tipo caja" :sublabel="optional($caja->tipo_caja ?? null)->descripcion ?? null" ></x-master.item>
                <x-master.item class="mb-4" label="Serie" :sublabel="$caja->serie ?? null" ></x-master.item>
                <x-master.item class="mb-4" label="Oficina" :sublabel="optional($caja->oficina)->descripcion" ></x-master.item>
                <x-master.item class="mb-4" label="Descripcion" :sublabel="$caja->descripcion" ></x-master.item>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4 mt-3">
        <div class="card-white">
            <div class="card-body">
                <h2 class="text-center" style="font-size: 16px; font-weight: bold;">
                    Usuarios Asignados
                </h2>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Oficina</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($caja->cajeros as $cajero)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $cajero->persona->nro_doc }}</td>
                                <td>{{ $cajero->descripcion }}</td>
                                <td>{{ $cajero->oficina->descripcion }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-white">
            <div class="card-body">
                <h2 class="text-center" style="font-size: 16px; font-weight: bold;">
                    Comprobantes Registrados
                </h2>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Comprobante</th>
                            <th>Serie</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($caja->comprobantes as $comprobante)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $comprobante->tipo_comprobante->descripcion }}</td>
                                <td>{{ $comprobante->serie }}</td>
                                <td>
                                    @can('intranet.caja.mantenimiento.caja.comprobante.edit')
                                        <a href="#addComprobante" wire:click="edit({{ $comprobante->id }})" class="btn btn-success btn-sm">
                                            <i class="la la-edit"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

