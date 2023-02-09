<x-master.modal id-modal="showTripulacionModal">
    <div wire:loading class="w-full">
        <div class="loader">Cargando...</div>
    </div>
    <div wire:loading.remove>
        @if (is_null($tripulacion))
            <div class="loader">Cargando...</div>
        @else
            <div class="row">
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Persona" :sublabel="optional($tripulacion->persona)->descripcion" ></x-master.item>
                        </div>
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Tipo tripulacion" :sublabel="optional($tripulacion->tipo_tripulacion)->descripcion" ></x-master.item>
                        </div>
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Nro licencia" :sublabel="$tripulacion->nro_licencia" ></x-master.item>
                        </div>
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Fecha vencimiento licencia" :sublabel="$tripulacion->fecha_vencimiento_licencia" ></x-master.item>
                        </div>

            </div>
        @endif
    </div>
    <div class="modal-action">
        <a href="#" class="btn btn-ghost">Cerrar</a>
    </div>

</x-master.modal>
