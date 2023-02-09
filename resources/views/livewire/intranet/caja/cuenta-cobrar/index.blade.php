<div>
    <x-master.item label="Cuentas por Cobrar" class="col-span-3 my-4">
        <x-slot name="sublabel">
            Lista de Clientes con Cuentas por Cobrar
        </x-slot>
        <x-slot name="actions">
            @can('intranet.caja.cuenta-cobrar.create')
                <a class="btn btn-success btn-sm" href="#clienteModal">
                    <i class="la la-add"></i> Registrar Cuenta
                </a>
            @endcan
        </x-slot>
    </x-master.item>
    @include('livewire.intranet.caja.cuenta-cobrar.components.modal-cliente')
    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                    <div class="grid grid-cols-4 gap-4">
                        <x-master.select label="Oficina" name="oficina_id" type="date" wire:model="oficina_id" :options="$oficinas" ></x-master.select>
                        <x-master.input label="Desde" name="desde" type="date" wire:model="desde"></x-master.input>
                        <x-master.input label="Hasta" name="hasta" type="date" wire:model="hasta"></x-master.input>
                        <x-master.input label="N° Doc Cliente" placeholder="Buscar..." name="nro_doc" wire:model.debounce.700ms="nro_doc"></x-master.input>
                    </div>
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Oficina</th>
                        <th class="text-center">N° Cuenta</th>
                        <th class="text-center">N° Doc</th>
                        <th class="text-center">Cliente</th>
                        <th class="text-center">Fecha de Registro</th>
                        <th class="text-center">Importe (S/.)</th>
                        <th class="text-center">Estado</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $row->oficina->descripcion }}</td>
                            <td class="text-center">{{ $row->codigo }}</td>
                            <td class="text-center">{{ $row->nro_doc_cliente }}</td>
                            <td>{{ $row->nombre_cliente }}</td>
                            <td class="text-center">{{ $row->fecha_registro->format('Y-m-d') }}</td>
                            <td class="text-right">@soles($row->importe)</td>
                            <td>
                                @include('livewire.intranet.caja.cuenta-cobrar.components.estado')
                            </td>
                            <td class="text-center">
                                <a href="{{ route('intranet.caja.cuenta-cobrar.show', $row) }}" class="btn btn-circle btn-sm btn-primary">
                                    <i class="la la-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
        <div wire:loading>
            @include('components.loader-horizontal-sm')
        </div>
    </div>
</div>
