<x-master.modal id-modal="createGuiaDespachoDetalleModal" wSize="4xl">
    <h4 class="text-lg font-semibold">Encomienda</h4>
    <form wire:submit.prevent="saveDetalle">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
            <livewire:intranet.tracking-carga.guia-despacho.components.create-detalle key="{{ now() }}"
                :guia-despacho="$guia_despacho" :guia-despacho-detalle-id="$edit_guia_despacho_detalle_id" />
        </div>
    </form>

</x-master.modal>
