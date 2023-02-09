<div x-data>
    <div class="cabecera p-6">
        <x-master.item label="Tarifas de exceso de equipajes / Traslado de mascotas" sublabel="Listado">
            <x-slot name="avatar">
                <i class="la la-list"></i>
            </x-slot>
        </x-master.item>
    </div>
    <div class="w-full tabs tabs-boxed">
        @foreach ($tarifa_bultos->groupBy('tipo_vuelo.descripcion') as $tipo_vuelo => $_)
            <a class="tab {{ $tab == $tipo_vuelo ? ' tab-active' : '' }}"
                wire:click="setTab('{{ $tipo_vuelo }}')">{{ $tipo_vuelo }}</a>
        @endforeach
    </div>
    @include('livewire.intranet.configuracion.tarifa-bulto.components.create')
    <div class="card-white">
        <div class="mt-2 overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Peso max</th>
                        <th>Monto por kg exces.</th>
                        <th>Monto referencial</th>
                        <th>¿Es editable?</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarifa_bultos->groupBy('tipo_vuelo.descripcion') as $tipo_vuelo => $tarifas)
                        @if ($tab == $tipo_vuelo)
                            @foreach ($tarifas as $tarifa)
                                <tr>
                                    <td>{{ $tarifa->id }}</td>
                                    <td>{{ optional($tarifa->tipo_bulto)->descripcion }}</td>
                                    <td>{{ $tarifa->peso_max }}</td>
                                    <td>
                                        @if (!$tarifa->is_monto_fijo)
                                            @soles($tarifa->monto_kg_excedido)
                                        @endif
                                    </td>
                                    <td>
                                        @if ($tarifa->is_monto_fijo)
                                            @soles($tarifa->monto_kg_excedido)
                                        @endif
                                    </td>
                                    <td>{{ $tarifa->is_monto_editable ? 'Sí' : 'No' }}</td>
                                    <td>
                                        @can('intranet.configuracion.tarifa-bulto.edit')
                                            <a href="#createTarifaBultoModal" wire:click="edit({{ $tarifa->id }})"
                                                class="btn btn-circle btn-sm btn-warning">
                                                <i class="la la-edit"></i>
                                            </a>
                                        @endcan
                                        @if (Auth::user()->can('intranet.configuracion.tarifa-bulto.delete') && $tarifa->doesntHave('pasaje_bultos'))
                                            <button class="btn btn-circle btn-sm btn-danger"
                                                wire:click="delete({{ $tarifa->id }})"
                                                onclick="confirm('¿Está seguro de eliminar?')||event.stopImmediatePropagation()">
                                                <i class="la la-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
