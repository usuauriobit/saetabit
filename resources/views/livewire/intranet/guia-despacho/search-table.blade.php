<div>
    <h4 class="text-lg font-semibold">Buscar guía de despacho</h4>
    <div wire:loading class="w-full">
        <div class="loader">Cargando...</div>
    </div>
    <div wire:loading.remove>
        <x-master.datatable :items="$items">
            <x-slot name="actions">
                <x-master.input placeholder="Buscar ..." name="search" wire:model="search"></x-master.input>
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
                @foreach($items as $row)
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
                            <i class="la la-plane-departure"></i> {{ optional(optional($row->origen)->ubigeo)->distrito }} <br>
                            <i class="la la-plane-arrival"></i> {{ optional(optional($row->destino)->ubigeo)->distrito }}
                        </td>
                        <td>{{ optional($row->fecha)->format('Y-m-d') }}</td>
                        {{-- <td>{{ $row->total }}</td> --}}
                        <td>
                            @include('livewire.intranet.tracking-carga.guia-despacho.components.guia-despacho-status', ['guia-despacho' => $row])
                        </td>
                        <td class="w-3">
                            <button wire:click="setGuiaDespacho('{{$row->id}}')"
                                class="btn btn-circle btn-sm btn-success">
                                <i class="la la-check"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-master.datatable>
    </div>
</div>
