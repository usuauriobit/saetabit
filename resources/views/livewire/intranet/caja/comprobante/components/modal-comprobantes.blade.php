<x-master.modal wire.key="{{ now() }}" id-modal="createNotaCreditoModal" w-size="6xl" label="Lista de Comprobantes Disponibles para Nota de Crédito">
    <x-master.datatable :items="$comprobantes_disponibles">
        <x-slot name="actions">
            <div class="grid grid-cols-4 gap-4">
                <x-master.input label="Desde" name="desde_c" wire:model="desde_c" type="date"></x-master.input>
                <x-master.input label="Hasta" name="hasta_c" wire:model="hasta_c" type="date"></x-master.input>
                <x-master.input label="Doc Cliente" name="nro_documento" wire:model.debounce.700ms="nro_documento" placeholder="Buscar..."></x-master.input>
                <x-master.input label="Nombre Cliente" name="search" wire:model.debounce.700ms="search" placeholder="Buscar..."></x-master.input>
            </div>
        </x-slot>
        <x-slot name="thead">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Comprobante N°</th>
                <th class="text-center">N° Doc</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Importe</th>
                <th></th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($comprobantes_disponibles as $comprobante_disponible)
                @if ($comprobante_disponible->disponible_nota_credito)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center"> {{ $comprobante_disponible->serie_correlativo }} </td>
                        <td class="text-center"> {{ $comprobante_disponible->nro_documento }} </td>
                        <td> {{ $comprobante_disponible->denominacion }} </td>
                        <td class="text-center"> {{ optional($comprobante_disponible->fecha_emision ?? null)->format('d-m-Y') }} </td>
                        <td class="text-right">
                            <div class="text-primary text-lg">
                                <strong>@soles($comprobante_disponible->total_importe)</strong>
                            </div>
                        </td>
                        <td>
                            <button wire:click="enviarDatosFacturacion({{ $comprobante_disponible->id }})" class="btn btn-outline btn-circle btn-success">
                                <i class="la la-check"></i>
                            </button>
                        </td>
                    </tr>
                @endif
            @endforeach
        </x-slot>
    </x-master.datatable>
</x-master.modal>
