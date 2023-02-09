<x-master.modal id-modal="showCuentaBancariaReferencialModal">
    <div wire:loading class="w-full">
        <div class="loader">Cargando...</div>
    </div>
    <div wire:loading.remove>
        @if (is_null($cuenta_bancaria_referencial))
            <div class="loader">Cargando...</div>
        @else
            <div class="row">
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Nro cuenta" :sublabel="$cuenta_bancaria_referencial->nro_cuenta" ></x-master.item>
                        </div>
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Descripcion cuenta" :sublabel="$cuenta_bancaria_referencial->descripcion_cuenta" ></x-master.item>
                        </div>
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Glosa" :sublabel="$cuenta_bancaria_referencial->glosa" ></x-master.item>
                        </div>

            </div>
        @endif
    </div>
    <div class="modal-action">
        <a href="#" class="btn btn-ghost">Cerrar</a>
    </div>

</x-master.modal>
