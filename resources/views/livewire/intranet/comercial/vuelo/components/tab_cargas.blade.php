<div>
    <x-master.item label="Cargas / Encomiendas" sublabel="Lista de cargas / encomiendas del vuelo">
        <x-slot name="avatar">
            <i class="las la-box"></i>
        </x-slot>
        <x-slot name="actions">
            @if (!$vuelo->is_closed)
                <a href="#" wire:click="printManifiestoCarga()" class="btn btn-warning mr-2"> <i class="las la-print"></i> Reporte</a>
                <a href="#searchTable" class="btn btn-primary">Registrar</a>
            @endif
        </x-slot>
    </x-master.item>

    <x-master.modal id-modal="searchTable" w-size="6xl">
        <livewire:intranet.guia-despacho.search-table :ubicacion-id="$vuelo->origen_id"/>
    </x-master.modal>

    <div class="mt-2 overflow-x-auto">
        <table class="table w-full">
            <tr>
                <th>#</th>
                <th>Codigo</th>
                <th>Remitente</th>
                <th>Consignatario</th>
                <th>Ruta</th>
                <th>Fecha</th>
                <th>Importe</th>
                <th>Estado</th>
                <th></th>
            </tr>
            @foreach($vuelo->guias_despacho_vuelo as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ optional($row->guia_despacho)->codigo }}</td>
                    <td>
                        <small>
                            {{ optional(optional($row->guia_despacho)->remitente)->nombres }} <br>
                            {{ optional(optional($row->guia_despacho)->remitente)->apellidos }}
                        </small>
                    </td>
                    <td>
                        <small>
                            {{ optional(optional($row->guia_despacho)->consignatario)->nombres }} <br>
                            {{ optional(optional($row->guia_despacho)->consignatario)->apellidos }}
                        </small>
                    </td>
                    <td>
                        <i class="la la-plane-departure"></i> {{ optional(optional($row->origen)->ubigeo)->distrito }} <br>
                        <i class="la la-plane-arrival"></i> {{ optional(optional($row->destino)->ubigeo)->distrito }}
                    </td>
                    <td>{{ optional(optional($row->guia_despacho)->fecha)->format('Y-m-d') }}</td>
                    <td>{{ optional($row->guia_despacho)->total }}</td>
                    <td>
                        @include('livewire.intranet.tracking-carga.guia-despacho.components.guia-despacho-status', ['guia-despacho' => $row])
                    </td>
                    <td class="w-3">
                        <button type="button" wire:click="deleteGuiaDespachoStep('{{$row->id}}')"
                            class="btn btn-circle btn-sm btn-danger">
                            <i class="la la-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
