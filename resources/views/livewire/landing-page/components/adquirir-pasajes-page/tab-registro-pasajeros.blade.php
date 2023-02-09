<div class="container mx-auto" x-data="{ tab: '' }" x-init="tab = $wire.tarifasIda[0]['descripcion']">
    <div class="grid grid-cols-5 cabecera p-6">
        <div class="col-span-3">
            <div class="tabs">
                <template x-for="tarifa in $wire.tarifasIda">
                    <a @click="tab = tarifa.descripcion" class="tab tab-lg tab-bordered"
                        :class="tab === tarifa.descripcion ? 'tab-active' : ''">
                        <i class="la la-user"></i>&nbsp;
                        <span x-text="tarifa.descripcion"></span>
                        {{-- <span class="badge badge-accent ml-1">Listo</span> --}}
                    </a>
                </template>
            </div>
            <template x-for="tarifa in $wire.tarifasIda">
                Tipo de documento
                Nro de documento
                Nombre
                Apellido paterno
                Apellido materno
                Fecha de nacimiento
            </template>
        </div>
        <div class="col-span-2">
            <div class="card-white">
                <div class="card-body">
                    {{ var_dump($tarifasIda) }}
                </div>
            </div>
        </div>
    </div>
</div>
