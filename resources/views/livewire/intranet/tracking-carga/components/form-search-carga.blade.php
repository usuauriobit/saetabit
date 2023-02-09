<div class=" card-white">
    <div class=" card-body"
        style="
            background: url('{{ asset('img/default/colorful3.jpg') }}');
            background-repeat: no-repeat;
            background-size: cover;
        "
    >
        <div class="grid items-center grid-cols-1 gap-4 lg:grid-cols-3">
            <div class="mx-auto text-center text-white lg:col-span-2">
                <div class="text-center ">
                    <img class="w-40 mx-auto mb-4 border-4 rounded-lg rotate-12"
                        src="{{ asset('img/asset/paquete.jpg') }}" alt="">
                </div>
                <p class="mt-2 text-3xl font-extrabold leading-8 tracking-tight sm:text-4xl">
                    Tracking de carga
                </p>
                <p class="max-w-2xl mt-4 text-xl">
                    Sección de búsqueda de cargas
                </p>
            </div>
            <div>
                <div class="card-white">
                    <div class="card-body">
                        <form wire:submit.prevent="searchCarga">
                            <x-master.input wire:model.defer="codigo_guia_despacho" label="Buscar guía de despacho" placeholder="Ingresar código de guía de despacho"/>
                            <button type="submit" class="w-full mt-4 btn btn-primary" wire:loading.attr="disabled">
                                <div wire:loading>
                                    @include('components.loader-horizontal-sm')
                                </div>
                                <div wire:loading.remove>
                                    <i class="mr-2 la la-search"></i>
                                    Buscar
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
