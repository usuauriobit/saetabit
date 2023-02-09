<div class=" card-white">
    <div class=" card-body"
        style="
            background: url('{{ asset('img/default/colorful10.jpg') }}');
            background-repeat: no-repeat;
            background-size: cover;
        "
    >
        <div class="grid items-center grid-cols-1 gap-4 lg:grid-cols-3">
            <div class="mx-auto text-center text-white lg:col-span-2">
                <div class="text-center ">
                    <img class="w-40 mx-auto mb-4  rotate-12"
                        src="{{ asset('img/repo/plane-2.png') }}" alt="">
                </div>
                <p class="mt-2 text-3xl font-extrabold leading-8 tracking-tight sm:text-4xl">
                    Búsqueda de vuelo
                </p>
                <p class="max-w-2xl mt-4 text-xl">

                </p>
            </div>
            <div>
                <div class="card-white">
                    <div class="card-body">
                        <form wire:submit.prevent="searchVuelo">
                            <x-master.input wire:model="codigo_vuelo" label="Buscar vuelo" placeholder="Ingresar código de vuelo"/>
                            <button type="submit" class="w-full mt-4 btn btn-primary">
                                <i class="mr-2 la la-search"></i>
                                Buscar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
