<x-master.modal id-modal="showRutaModal">
    <div wire:loading class="w-full">
        <div class="loader">Cargando...</div>
    </div>
    <div wire:loading.remove>
        @if (is_null($ruta))
        <div class="loader">Cargando...</div>
        @else
        <div class="row">
            <div class="col-md-12">
                <x-master.item class="mb-4" label="ID" :sublabel="$ruta->id">
                </x-master.item>
            </div>
            <div class="col-md-12">
                <x-master.item class="mb-4" label="Tipo vuelo" :sublabel="optional($ruta->tipo_vuelo)->descripcion">
                </x-master.item>
            </div>
            <div class="col-md-12">
                <x-master.item class="mb-4" label="Tramo" :sublabel="optional($ruta->tramo)->descripcion">
                </x-master.item>
            </div>

        </div>
        @endif
    </div>
    <div class="modal-action">
        <a href="#" class="btn btn-ghost">Cerrar</a>
    </div>

</x-master.modal>
