<div class="card-white">
    <div class="p-4"
    style="background-image: url('{{ asset('img/default/colorful6.jpg') }}'); background-position:; background-repeat: no-repeat; background-size: cover;"
    >
        <div class="card-white card-body">
            <div class="mb-2 text-lg font-bold">Datos del cliente</div>
            <div class="grid grid-cols-2 lg:grid-cols-5">
                <div class="col-span-2">
                    <div class="flex-center">
                        <img style="height:80px" class="mb-2" src="{{asset('img/repo/user.png')}}" alt="">
                        @if (get_class($cliente) == 'App\Models\Cliente')
                            <p> {{$cliente->razon_social}} </p>
                            <div class="badge badge-success">
                                RUC
                                : {{$cliente->ruc}}
                            </div>
                        @else
                            <p> {{$cliente->nombre_completo}} </p>
                            <div class="badge badge-success">
                                {{optional($cliente->tipo_documento)->descripcion}}
                                : {{$cliente->nro_doc}}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 col-span-3">
                    @if (get_class($cliente) == 'App\Models\Cliente')
                        {{-- <x-master.item class="my-2" label="RUC" :sublabel="$cliente->ruc" ></x-master.item>
                        <x-master.item class="my-2" label="Razón social" :sublabel="$cliente->razon_social" ></x-master.item> --}}
                        <x-master.item class="my-2" label="Nombre comercial" :sublabel="$cliente->nombre_comercial" ></x-master.item>
                        <x-master.item class="my-2" label="Ubigeo" :sublabel="optional($cliente->ubigeo)->descripcion" ></x-master.item>
                    @else
                        {{-- <div class="flex justify-center w-full my-2">
                            <img src="{{ asset('img/repo/user.png') }}" class="w-24 h-24 ">
                        </div> --}}
                        {{-- <x-master.item class="my-2" label="Tipo documento" :sublabel="optional($cliente->tipo_documento)->descripcion" ></x-master.item>
                        <x-master.item class="my-2" label="Nro documento" :sublabel="$cliente->nro_doc" ></x-master.item>
                        <x-master.item class="my-2" label="Nombre completo" :sublabel="$cliente->nombre_completo" ></x-master.item> --}}
                        <x-master.item class="my-2" label="Fecha de nacimiento" :sublabel="optional($cliente->fecha_nacimiento)->format('Y-m-d')" ></x-master.item>
                        <x-master.item class="my-2" label="Edad" :sublabel="$cliente->edad" ></x-master.item>
                        <x-master.item class="my-2" label="Sexo" :sublabel="$cliente->sexo_desc" ></x-master.item>
                        <x-master.item class="my-2" label="Teléfono" :sublabel="$cliente->ultimo_telefono" ></x-master.item>
                        <x-master.item class="my-2" label="Lugar Procedencia" :sublabel="optional($cliente->ubigeo ?? null)->distrito" ></x-master.item>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="tabs tabs-boxed">
        <a class="tab" :class="{ 'tab-active' : $wire.tab == 'pagos' }" wire:click="setTab('pagos')">Pagos</a>
        <a class="tab" :class="{ 'tab-active' : $wire.tab == 'vuelos' }" wire:click="setTab('vuelos')">Pasajes</a>
        <a class="tab" :class="{ 'tab-active' : $wire.tab == 'encomiendas' }" wire:click="setTab('encomiendas')">Encomiendas</a>
        <a class="tab" wire:loading>
            @include('components.loader-horizontal-sm')
        </a>
    </div>
</div>
