@php
$items = [
    [
        'title' => 'Vuelos chárter',
        'icon' => 'las la-plane-departure',
        // 'action' => route('')
    ],
    [
        'title' => 'Aero médico',
        'icon' => 'las la-medkit',
        // 'action' => route('')
    ],
    [
        'title' => 'Envío de carga, encomiendas y sobres',
        'icon' => 'las la-box',
        // 'action' => route('')
    ],
    [
        'title' => 'Vuelos subvencionados',
        'icon' => 'las la-plane-departure',
        // 'action' => route('')
    ],
    [
        'title' => 'Vuelos chárter',
        'icon' => 'las la-plane-departure',
        // 'action' => route('')
    ],
];
@endphp
<div class="" style="padding-top: 100px; padding-bottom: 100px">
    <div class="container mx-auto grid lg:grid-cols-2 items-center gap-12 ">
        <div class="col-span-2 lg:col-span-1 justify-self-center">
            <h3 class="text-4xl font-bold">Nuestros servicios</h3>
            <p class="py-4">
                Disfruta de nuestros servicios de alta calidad
            </p>
            <div class="inline-flex w-16 h-1 bg-indigo-500 rounded-full"></div>

            <div class="my-8">
                @foreach ($items as $item)
                    <div class="flex items-center gap-4 mb-5">
                        <div
                            class="inline-flex items-center justify-center flex-shrink-0 w-20 h-20  text-indigo-500 bg-indigo-100 rounded-full">
                            <i style="font-size: 35px" class="{{ $item['icon'] }}"></i>
                        </div>
                        <p class="text-xl">{{ $item['title'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-span-2 lg:col-span-1 text-center justify-self-center">
            <div>
                <div class="rellax" data-rellax-speed="0" style="background: linear-gradient(39.92deg, #A9E3EF 1.32%, #7B85E8 66.05%); height: 250px; width: 250px; border-radius: 10px;">
                </div>
                <img class="rellax" data-rellax-speed="1" style=" height: 250px; width: 250px; margin-top: -270px; margin-left: -20px;" src="{{ asset('img/square-1.png') }}" alt="">
            </div>
            <div style="margin-top: -50px; margin-left: 100px">
                <div class="rellax" data-rellax-speed="0" style="background: linear-gradient(118.23deg, #75D6FF 27.35%, #9A9DBE 78.56%); height: 250px; width: 250px; border-radius: 10px;">
                </div>
                <img class="rellax" data-rellax-speed="1" style=" height: 250px; width: 250px; margin-top: -270px; margin-left: -20px;" src="{{ asset('img/square-2.png') }}" alt="">
            </div>
            <div style="margin-top: -40px; margin-left: -60px">
                <div class="rellax" data-rellax-speed="0" style="background: linear-gradient(344.99deg, #5FABF1 10.9%, #C7E9F0 78.3%); height: 250px; width: 250px; border-radius: 10px;">
                </div>
                <img class="rellax" data-rellax-speed="1" style=" height: 250px; width: 250px; margin-top: -270px; margin-left: -20px;" src="{{ asset('img/square-3.png') }}" alt="">
            </div>
        </div>
    </div>
</div>
