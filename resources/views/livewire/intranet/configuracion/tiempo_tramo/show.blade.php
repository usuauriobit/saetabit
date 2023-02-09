<x-master.modal id-modal="showTiempoTramoModal">
    <div wire:loading class="w-full">
        <div class="loader">Cargando...</div>
    </div>
    <div wire:loading.remove>
        @if (is_null($tiempo_tramo))
            <div class="loader">Cargando...</div>
        @else
            <div class="row">
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Tramo" :sublabel="optional($tiempo_tramo->tramo)->descripcion" ></x-master.item>
                        </div>
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Avion" :sublabel="optional($tiempo_tramo->avion)->descripcion" ></x-master.item>
                        </div>
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Tiempo vuelo" :sublabel="$tiempo_tramo->tiempo_vuelo" ></x-master.item>
                        </div>

            </div>
        @endif
    </div>
    <div class="modal-action">
        <a href="#" class="btn btn-ghost">Cerrar</a>
    </div>

</x-master.modal>
