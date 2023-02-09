<x-master.modal id-modal="createVentaDetalleModal" label="Agregar Detalle a la Venta">
    <form wire:submit.prevent="save">
        <x-master.input label="Descripción" wire:model="form.descripcion" />
        <div class="grid grid-cols-2 gap-4">
            <x-master.input label="Cantidad" type="number" wire:model="form.cantidad" />
            <x-master.input label="Precio Unitario (S/.)" type="number" wire:model="form.monto" />
        </div>
        <button class="btn btn-success w-full btn-sm mt-2">Guardar</button>
    </form>
</x-master.modal>
