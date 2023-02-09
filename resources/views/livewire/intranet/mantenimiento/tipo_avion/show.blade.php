<x-master.modal id-modal="showTipoAvionModal">
    <div wire:loading class="w-full">
        <div class="loader">Cargando...</div>
    </div>
    <div wire:loading.remove>
        @if (is_null($tipo_avion))
            <div class="loader">Cargando...</div>
        @else
            <div class="row">
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Descripcion" :sublabel="$tipo_avion->descripcion" ></x-master.item>
                        </div>

            </div>
        @endif
    </div>
    <div class="modal-action">
        <a href="#" class="btn btn-ghost">Cerrar</a>
    </div>

</x-master.modal>
