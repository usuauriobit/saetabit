<section class="text-gray-600 body-font">
    <div class="container px-5 pb-16 mx-auto pt-7">
        <div class="mb-12 mt-4 text-center">
            <h1 class="mb-4 text-2xl font-medium text-gray-900 sm:text-3xl title-font">
                Nuestros servicios
            </h1>
            <p class="mx-auto text-base leading-relaxed xl:w-2/4 lg:w-3/4 text-gray-500s">
                Disfruta de nuestros servicios de alta calidad
            </p>
            <div class="flex justify-center mt-6">
                <div class="inline-flex w-16 h-1 bg-indigo-500 rounded-full"></div>
            </div>
        </div>
        <div class="grid grid-cols-3  gap-4  ">
            @foreach ($items as $item)
                @include('components.card_service', ['item' => $item])
            @endforeach
        </div>
    </div>
</section>
