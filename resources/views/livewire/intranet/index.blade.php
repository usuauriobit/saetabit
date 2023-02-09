<div class="container mx-auto xl:px-40">
    <div class="px-8 pt-4 bg-white shadow-lg mt-14 rounded-2xl"
        style="z-index: -1;
        background: url('{{ asset('img/default/colorful9.jpg') }}');
        background-size: cover;
        background-position: center;
    ">
        <div>
            <div class="flex justify-center -mt-16 md:justify-end">
                <img class="object-cover h-28" src="{{ asset('img/airplane.png') }}">
            </div>
            <div>
                <h2 class="pb-6 text-3xl font-semibold text-white">
                    Sistema interno de Saeta - Perú
                </h2>
            </div>
        </div>
    </div>

    <h4 class="my-5 ml-2 text-2xl font-bold text-gray-900">Lista de módulos</h4>


    <div class="grid grid-cols-1 gap-4 my-6 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
        @foreach ($modulos as $modulo)
            <div class="p-2 mx-1 transition duration-500 transform shadow-md card-white  motion-safe:hover:scale-105">
                <div class="relative overflow-x-hidden rounded-md">
                    <img class="object-cover w-full h-40 rounded-md" src="{{ $modulo['image_path'] }}">

                </div>
                <a href="{{ $modulo['route'] }}" class="">
                    <div class="flex justify-between px-2 mt-4 ">

                        <p class="mb-0 text-lg font-semibold text-gray-900">{{ $modulo['title'] }}</p>
                        <div class="btn btn-sm btn-circle">
                            <i class="la la-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
