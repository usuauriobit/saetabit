<x-master.modal id-modal="showPersonaModal">
    <div wire:loading class="w-full">
        <div class="loader">Cargando...</div>
    </div>
    <div wire:loading.remove>
        @if (is_null($persona))
            <div class="loader">Cargando...</div>
        @else
            <div class="row">
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Nacionalidad" :sublabel="optional($persona->nacionalidad)->descripcion" ></x-master.item>
                        </div>

						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Ubigeo" :sublabel="optional($persona->ubigeo)->descripcion" ></x-master.item>
                        </div>
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Lugar nacimiento" :sublabel="optional($persona->lugar_nacimiento)->descripcion" ></x-master.item>
                        </div>
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Tipo documento" :sublabel="optional($persona->tipo_documento)->descripcion" ></x-master.item>
                        </div>

						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Nro doc" :sublabel="$persona->nro_doc" ></x-master.item>
                        </div>
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Fecha nacimiento" :sublabel="$persona->fecha_nacimiento" ></x-master.item>
                        </div>

						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Nombres" :sublabel="$persona->nombres" ></x-master.item>
                        </div>
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Apellido parterno" :sublabel="$persona->apellido_paterno" ></x-master.item>
                        </div>
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Apellido materno" :sublabel="$persona->apellido_materno" ></x-master.item>
                        </div>
						<div class="col-md-12" >
                            <x-master.item class="mb-4" label="Photo url" :sublabel="$persona->photo_url" ></x-master.item>
                        </div>

            </div>
        @endif
    </div>
    <div class="modal-action">
        <a href="#" class="btn btn-ghost">Cerrar</a>
    </div>

</x-master.modal>
