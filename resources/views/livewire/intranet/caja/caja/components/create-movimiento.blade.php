<x-master.modal id-modal="createMovimientoModal" w-size="4xl" label="Lista de Ventas Disponibles">
    <x-master.item label="Lista" class="pb-3">
        <x-slot name="sublabel">
            <span class="font-weight-bold ms-1">{{ $ventas_disponibles->count() }}</span> de {{ $ventas_disponibles->total() }} resultados
        </x-slot>
        <x-slot name="avatar">
            <i class="text-2xl la la-list"></i>
        </x-slot>
        <x-slot name="actions">
            <div class="grid grid-cols-2 gap-4">
                <x-master.input label="N° Doc" placeholder="Buscar ..." name="search_ventas" wire:model="search_ventas"></x-master.input>
                <x-master.input label="Nombre Cliente" placeholder="Buscar ..." name="search_ventas_cliente" wire:model="search_ventas_cliente"></x-master.input>
            </div>
        </x-slot>
    </x-master.item>
    @foreach($ventas_disponibles as $venta_disponible)
        <div class="mb-4 shadow-lg">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>
                            <x-master.item label="#" sublabel="{{ $loop->iteration }}"/>
                        </th>
                        <th>
                            <x-master.item label="Venta N°" sublabel="{{ $venta_disponible->codigo }}"/>
                        </th>
                        <th>
                            <x-master.item label="N° Doc" sublabel="{{ $venta_disponible->nro_documento }}"/>
                        </th>
                        <th>
                            <x-master.item label="Cliente" sublabel="{{ $venta_disponible->descripcion_cliente }}"/>
                        </th>
                        <th>
                            <x-master.item label="Importe">
                                <x-slot name="sublabel">
                                    <div class="text-lg text-primary">
                                        <strong>@soles($venta_disponible->importe)</strong>
                                    </div>
                                </x-slot>
                            </x-master.item>
                        </th>
                        <th>
                            @can('intranet.caja.venta.show')
                                <button class="btn btn-outline btn-circle btn-success" wire:click="createMovimiento({{ $venta_disponible->id }})">
                                    <i class="la la-check"></i>
                                </button>
                            @endcan
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">
                            <ul>
                                @foreach ($venta_disponible->detalle as $detalle)
                                    <li>{{ $detalle->descripcion }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                </tbody>
              </table>
        </div>
    @endforeach

    <div class="div">
        {{$ventas_disponibles->links()}}
    </div>
</x-master.modal>
