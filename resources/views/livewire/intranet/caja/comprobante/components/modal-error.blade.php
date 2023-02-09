<x-master.modal id-modal="showErrorModal" w-size="4xl" label="Error al Facturar">
    <div wire:loading>
        @include('components.loader-horizontal-sm')
    </div>
    <p>{{ $error }}</p>
</x-master.modal>
