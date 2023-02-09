<x-master.modal wire:key="{{ 'modal-venta-' . $venta->id }}" id-modal="createMovimientoModal" wSize="6xl" label="Agregar Movimiento a la Venta">
    <livewire:intranet.caja.movimiento.create
        wire:key="{{ now() }}"
        :caja_apertura_cierre_id="$caja_apertura_cierre->id"
        :venta_id="$venta->id"
        {{-- :caja_id="$caja->id" --}}
    />
</x-master.modal>
