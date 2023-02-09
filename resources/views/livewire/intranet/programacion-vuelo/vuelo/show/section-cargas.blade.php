<div>
    {{-- <div class="w-full tabs tabs-boxed">
        <a class="tab {{ $tab == 'lista' ? ' tab-active' : '' }}"
            wire:click="setTab('lista')">Lista</a>
        <a class="tab {{ $tab == 'registrar' ? ' tab-active' : '' }}"
            wire:click="setTab('registrar')">Registrar carga</a>
    </div> --}}

    <div class="card-white">
        <div class="card-body">
            @if (!$vuelo->is_closed)
                @can('intranet.tracking-carga.guia-despacho.tracking.create')
                    <form wire:submit.prevent='buscarGuiaDespacho' class="mb-6">
                        <x-master.input label="Agregar guía de despacho" placeholder="Ingrese el código" wire:model.defer="form.codigo_guia_despacho">
                            <x-slot name="suffix">
                                <button type="submit" class="btn btn-primary">
                                    <i class="la la-plus"></i>
                                </button>
                            </x-slot>
                        </x-master.input>
                    </form>
                @endcan
            @endif

            @if ($tab == 'lista')
                <x-master.item label="Cargas / Encomiendas" sublabel="Lista de cargas / encomiendas del vuelo">
                    <x-slot name="avatar">
                        <i class="las la-box"></i>
                    </x-slot>
                    <x-slot name="actions">
                    {{-- @if (!$vuelo->is_closed)
                            <a href="#searchTable" class="btn btn-primary">Registrar</a>
    @endif--}}
                    </x-slot>
                </x-master.item>

                {{-- <x-master.modal id-modal="searchTable" w-size="6xl">
                </x-master.modal> --}}

                <div class="mt-2 overflow-x-auto">
                    <table class="table w-full">
                        <tr>
                            <th>#</th>
                            <th>Codigo</th>
                            <th>Remitente</th>
                            <th>Consignatario</th>
                            <th>Ruta</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                        @foreach($vuelo->guias_despacho_vuelo as $row)
                            <tr key="guiaTr{{$row->id}}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ optional($row->guia_despacho)->codigo }}</td>
                                <td>
                                    <small>
                                        {{ optional(optional($row->guia_despacho)->remitente)->nombres }}
                                        <br>
                                        {{ optional(optional($row->guia_despacho)->remitente)->apellidos }}
                                    </small>
                                </td>
                                <td>
                                    <small>
                                        {{ optional(optional($row->guia_despacho)->consignatario)->nombres }}
                                        <br>
                                        {{ optional(optional($row->guia_despacho)->consignatario)->apellidos }}
                                    </small>
                                </td>
                                <td>
                                    <i class="la la-plane-departure"></i>
                                    {{ optional(optional(optional($row->guia_despacho)->origen)->ubigeo)->distrito }} <br>
                                    <i class="la la-plane-arrival"></i>
                                    {{ optional(optional(optional($row->guia_despacho)->destino)->ubigeo)->distrito }}
                                </td>
                                <td>{{ optional(optional($row->guia_despacho)->fecha)->format('Y-m-d') }}
                                </td>
                                <td>
                                    @include('livewire.intranet.tracking-carga.guia-despacho.components.guia-despacho-status', ['guia_despacho' => $row->guia_despacho])

                                </td>
                                <td class="w-3">
                                    @if (!$vuelo->is_closed)
                                        @can('intranet.tracking-carga.guia-despacho.tracking.delete')
                                            <button type="button"
                                                onclick="confirm('¿Está seguro de eliminar? No podrá recuperarlo después')||event.stopImmediatePropagation()"
                                                wire:click="deleteGuiaDespachoStep('{{ $row->id }}')"
                                                class="btn btn-circle btn-sm btn-danger">
                                                <i class="la la-trash"></i>
                                            </button>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
            @if ($tab == 'registrar')
                <livewire:intranet.guia-despacho.search-table key="{{now()}}" :ubicacion-id="$vuelo->origen_id" />
            @endif
        </div>
    </div>

</div>
