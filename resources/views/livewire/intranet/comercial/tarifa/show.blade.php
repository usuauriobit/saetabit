<x-master.modal id-modal="showTarifaModal">
    <div wire:loading class="w-full">
        <div class="loader">Cargando...</div>
    </div>
    <div wire:loading.remove>
        @if(is_null($tarifa))
            <div class="loader">Cargando...</div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <x-master.item class="mb-4" label="Ruta" :sublabel="optional($tarifa->ruta)->descripcion">
                    </x-master.item>
                </div>
                <div class="col-md-12">
                    <x-master.item class="mb-4" label="Tipo pasajero"
                        :sublabel="optional($tarifa->tipo_pasaje)->descripcion"></x-master.item>
                </div>
                <div class="col-md-12">
                    <x-master.item class="mb-4" label="Descripcion" :sublabel="$tarifa->descripcion"></x-master.item>
                </div>
                <div class="col-md-12">
                    <x-master.item class="mb-4" label="Precio" :sublabel="$tarifa->precio"></x-master.item>
                </div>
                <div class="col-md-12">
                    <x-master.item class="mb-4" label="Maximo equipaje" :sublabel="$tarifa->maximo_equipaje">
                    </x-master.item>
                </div>
            </div>
        @endif
    </div>
    <div class="modal-action">
        <a href="#" class="btn btn-ghost">Cerrar</a>
    </div>
</x-master.modal>
