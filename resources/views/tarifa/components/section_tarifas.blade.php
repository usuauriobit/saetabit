<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-col w-full mb-20 text-center">
            <h1 class="mb-4 text-2xl font-medium tracking-widest text-gray-900 title-font">Tarifas</h1>
            <p class="mx-auto text-base leading-relaxed lg:w-2/3">
                Porque sabemos que cada vuelo es diferente, te presentamos una nueva forma de comprar tus pasajes donde
                tú eliges cómo viajar. Busca la tarifa que más te convenga según tus necesidades
            </p>
        </div>
        <div class="flex flex-wrap -m-4">
            @php
                $tarifas = [
                    [
                        'imagen_path' => asset('img/ticket-promo.png'),
                        'titulo' => 'Promo',
                        'sections' => [
                            [
                                'titulo' => 'Incluye',
                                'items' => ['1 artículo personal de 45 x 35 x 20 cm (alto, largo y ancho)', 'Asiento asignado al azar'],
                            ],
                            [
                                'titulo' => 'Puedes pagar',
                                'items' => [' Equipaje de bodega de 158 cm lineales, largo + ancho + alto (equipaje de mano no disponible para la venta)', 'Selección de asiento'],
                            ],
                        ],
                        'alert' => 'Si tu artículo personal <strong> no cumple con la cantidad o el tamaño permitido </strong>, tendrás que pagar <strong>costo extra</strong>. Caso contrario, no podremos embarcarlo ni hacernos responsables de su custodia.',
                    ],
                    [
                        'imagen_path' => asset('img/tikcet-ligera.png'),
                        'titulo' => 'Ligera',
                        'sections' => [
                            [
                                'titulo' => 'asd',
                                'items' => ['asdadsasd', 'adsasdasddfggfd gdfgdfg', 'dfg asdsfdsgdfhg'],
                            ],
                        ],
                    ],
                    [
                        'imagen_path' => asset('img/ticket-completa.png'),
                        'titulo' => 'Completa',
                        'sections' => [
                            [
                                'titulo' => 'asd',
                                'items' => ['asdadsasd', 'adsasdasddfggfd gdfgdfg', 'dfg asdsfdsgdfhg'],
                            ],
                        ],
                    ],
                ];
            @endphp
            @foreach ($tarifas as $tarifa)
                <section class="text-gray-600 body-font">
                    <div class="container flex flex-col items-center px-5 py-24 mx-auto md:flex-row">
                        <div
                            class="flex flex-col items-center mb-16 text-center lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 md:items-start md:text-left md:mb-0">
                            <h1 class="mb-4 text-3xl font-medium text-gray-900 title-font sm:text-4xl">

                                Knausgaard typewriter readymade marfa</h1>
                            <p class="mb-8 leading-relaxed">Chillwave portland ugh, knausgaard fam polaroid iPhone. Man
                                braid swag typewriter affogato, hella selvage wolf narwhal dreamcatcher.</p>
                        </div>
                        <div class="w-5/6 lg:max-w-lg lg:w-full md:w-1/2">
                            <img class="object-cover object-center rounded" alt="hero"
                                src="{{ $tarifa['imagen_path'] }}">
                        </div>
                    </div>
                </section>

                {{-- @include('tarifa.components.card_tarifa_item') --}}
            @endforeach
        </div>
    </div>
</section>
