<x-master.modal id-modal="showPersonalModal">
    <div wire:loading class="w-full">
        <div class="loader">Cargando...</div>
    </div>
    <div wire:loading.remove>
        @if(is_null($personal))
            <div class="loader">Cargando...</div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <x-master.item class="mb-4" label="Oficina" :sublabel="optional($personal->oficina)->descripcion">
                    </x-master.item>
                </div>
                <div class="col-md-12">
                    <x-master.item class="mb-4" label="Persona"
                        :sublabel="optional($personal->persona)->nombre_completo"></x-master.item>
                </div>
                <div class="col-md-12">
                    <x-master.item class="mb-4" label="Fecha ingreso"
                        :sublabel="optional($personal->fecha_ingreso)->format('Y-m-d')"></x-master.item>
                </div>

            </div>
        @endif
    </div>
    <div class="modal-action">
        <a href="#" class="btn btn-ghost">Cerrar</a>
    </div>

</x-master.modal>
