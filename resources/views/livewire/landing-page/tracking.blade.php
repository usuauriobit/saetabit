<div class="bg-gray-50 min-h-screen">
    <livewire:intranet.tracking-carga.components.form-search-carga />

    <div class="container mx-auto cabecera p-6">
        @if ($guia_despacho)
            <livewire:intranet.tracking-carga.components.track-section
                onlyShow
                :guia-despacho="$guia_despacho"
                wire:key="{{ now() }}"
            />
        @else
            <div class="card-white">
                <div class="card-body">
                    <div class="text-center">
                        <i class="la la-boxes text-primary" style="font-size: 80px"></i>
                        <div class="text-2xl my-4">
                            <strong>Resultados de la búsqueda</strong>
                        </div>
                        <p class="text-grey-500">
                            Ingrese el código de la guía de despacho para realizar la búsqueda.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
