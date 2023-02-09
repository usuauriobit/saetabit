<div>
    @section('title', __('Guia despachos'))
    <div class="cabecera p-6">
        <x-master.item label="Guia despachos" sublabel="Lista de Guia despachos">
            <x-slot name="label">
                @if ($this->oficina_selected)
                    Oficina: <strong>{{ optional($this->oficina_selected)->descripcion }}</strong>
                @else
                    Guías de despacho
                @endif
            </x-slot>
            <x-slot name="actions">
                {{-- <div class="grid grid-cols-5 justify-start items-end gap-4">
                    <div class="w-36">
                        <x-master.input wire:model="from" label="Fecha de inicio" type="date" />
                    </div>
                    <div class="w-36">
                        <x-master.input wire:model="to" label="Fecha final" type="date" />
                    </div>
                    <x-master.select wire:model="ubigeoOrigenSelected" label="Origen" :options="$ubigeoOrigenOptions" />
                    <x-master.select wire:model="ubigeoDestinoSelected" label="Destino" :options="$ubigeoDestinoOptions" />
                    <div class="w-32">
                        <x-master.select wire:model="estadoSelected" label="Estado" :options="$estadoOptions" />
                    </div>
                </div> --}}
            </x-slot>
        </x-master.item>
        <div class="grid grid-cols-5 items-end gap-4">
            <x-master.input wire:model="from" label="Fecha de inicio" type="date" />
            <x-master.input wire:model="to" label="Fecha final" type="date" />
            <x-master.select wire:model="ubigeoOrigenSelected" label="Origen" :options="$ubigeoOrigenOptions" />
            <x-master.select wire:model="ubigeoDestinoSelected" label="Destino" :options="$ubigeoDestinoOptions" />
            <x-master.select wire:model="estadoSelected" label="Estado" :options="$estadoOptions" />
        </div>
    </div>

    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                    <div class="grid grid-cols-2 gap-4">
                        <x-master.input label="N° Documento" placeholder="N° doc ..." name="nro_documento" wire:model.debounce.700ms="nro_documento"></x-master.input>
                        <x-master.input label="Nombre" placeholder="Buscar ..." name="search" wire:model.debounce.700ms="search"></x-master.input>
                    </div>
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Codigo</th>
                        <th>Remitente</th>
                        <th>Consignatario</th>
                        <th>Ruta</th>
                        <th>Fecha</th>
                        {{-- <th>Importe</th> --}}
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->codigo }}</td>
                            <td>
                                <small>
                                    {{ optional($row->remitente)->nombres }} <br>
                                    {{ optional($row->remitente)->apellidos }}
                                </small>
                            </td>
                            <td>
                                <small>
                                    {{ optional($row->consignatario)->nombres }} <br>
                                    {{ optional($row->consignatario)->apellidos }}
                                </small>
                            </td>
                            <td>
                                <i class="la la-plane-departure"></i>
                                {{ optional(optional($row->origen)->ubigeo)->distrito }} <br>
                                <i class="la la-plane-arrival"></i>
                                {{ optional(optional($row->destino)->ubigeo)->distrito }}
                            </td>
                            <td>{{ optional($row->fecha)->format('Y-m-d') }}</td>
                            {{-- <td>@soles($row->total)</td> --}}
                            <td>
                                @include('livewire.intranet.tracking-carga.guia-despacho.components.guia-despacho-status',
                                    ['guia_despacho' => $row])
                            </td>
                            <td class="w-3">
                                <a href="{{ route('intranet.tracking-carga.guia-despacho.show', $row->id) }}"
                                    class="btn btn-circle btn-sm btn-success">
                                    <i class="la la-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
