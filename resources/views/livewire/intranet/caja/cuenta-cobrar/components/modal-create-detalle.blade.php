<x-master.modal id-modal="addDetalleModal" label="Asignar detalle" wSize="4xl">
    <div x-data="{tab: 'subvencionados'}">
        <div class="w-full tabs tabs-boxed">
            <a class="tab" :class="tab == 'subvencionados' && 'tab-active'" x-on:click="tab = 'subvencionados'" >Vuelos Subvecionados</a>
            <a class="tab" :class="tab == 'charter' && 'tab-active'" x-on:click="tab = 'charter'" >Vuelos Charter</a>
            <a class="tab" :class="tab == 'guias' && 'tab-active'" x-on:click="tab = 'guias'" >Guías</a>
        </div>
        <div x-show="tab == 'subvencionados'">
            <x-master.datatable :items="$subvencionados">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Paquete</th>
                        <th>Ruta</th>
                        <th>N° Contrato</th>
                        <th>Importe (S/.)</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($subvencionados as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->paquete }}</td>
                            <td>{{ $row->ruta->descripcion }}</td>
                            <td>{{ $row->nro_contrato }}</td>
                            <td>@soles($row->monto_total)</td>
                            <td class="text-center">
                                <button wire:click="createDetalle('{{ Str::afterLast(get_class($row), '\\') }}','{{ $row->id }}')"
                                    class="btn btn-circle btn-sm btn-primary">
                                    <i class="la la-check"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
        <div x-show="tab == 'charter'">
            <x-master.datatable :items="$charter">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Ruta</th>
                        <th>Importe (S/.)</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($charter as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->vuelo_ruta->descripcion_ruta }}</td>
                            <td>@soles($row->monto_total)</td>
                            <td class="text-center">
                                <button wire:click="createDetalle('{{ Str::afterLast(get_class($row), '\\') }}','{{ $row->id }}')"
                                    class="btn btn-circle btn-sm btn-primary">
                                    <i class="la la-check"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
        <div x-show="tab == 'guias'">
            <x-master.datatable :items="$guias_venta">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Concepto</th>
                        <th>Importe (S/.)</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($guias_venta as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->descripcion }}</td>
                            <td>@soles($row->importe)</td>
                            <td class="text-center">
                                <button wire:click="createDetalle('{{ Str::afterLast(get_class($row), '\\') }}','{{ $row->id }}')"
                                    class="btn btn-circle btn-sm btn-primary">
                                    <i class="la la-check"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</x-master.modal>
