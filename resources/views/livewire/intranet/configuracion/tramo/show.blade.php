<x-master.modal id-modal="showTramoModal">
    <div wire:loading class="w-full">
        <div class="loader">Cargando...</div>
    </div>
    <div wire:loading.remove>
        @if (is_null($tramo))
            <div class="loader">Cargando...</div>
        @else
            <div class="row">
                <div class="col-md-12" >
                    <x-master.item class="mb-4" label="Origen" :sublabel="optional($tramo->origen)->descripcion" ></x-master.item>
                </div>
                <div class="col-md-12" >
                    <x-master.item class="mb-4" label="Destino" :sublabel="optional($tramo->destino)->descripcion" ></x-master.item>
                </div>
                <div class="col-md-12">
                    <x-master.item class="mb-4" label="Tiempo de vuelo (Minutos)" :sublabel="$tramo->minutos_vuelo" ></x-master.item>
                </div>
            </div>
        @endif
    </div>
    <div class="modal-action">
        <a href="#" class="btn btn-ghost">Cerrar</a>
    </div>

</x-master.modal>
