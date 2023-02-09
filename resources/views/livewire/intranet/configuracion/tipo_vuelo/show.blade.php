<x-master.modal id-modal="showTipoVueloModal">
    <div wire:loading class="w-full">
        <div class="loader">Cargando...</div>
    </div>
    <div wire:loading.remove>
        @if (is_null($tipo_vuelo))
            <div class="loader">Cargando...</div>
        @else
            <div class="row">
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Categoria vuelo" :sublabel="optional($tipo_vuelo->categoria_vuelo)->descripcion" ></x-master.item>
                        </div>
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Descripcion" :sublabel="$tipo_vuelo->descripcion" ></x-master.item>
                        </div>

            </div>
        @endif
    </div>
    <div class="modal-action">
        <a href="#" class="btn btn-ghost">Cerrar</a>
    </div>

</x-master.modal>
