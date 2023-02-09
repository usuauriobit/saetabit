{{-- <div class="hero" style="padding-top: 100px; padding-bottom: 100px;background: url('{{ asset('img/bg-airplane-1.png') }}');background-size: cover;">

    <div class="hero-content flex-col lg:flex-row gap-4" >
        <img src="{{ asset('img/money-bag.svg') }}" alt="" srcset="" class="rellax" data-rellax-speed="1">

        <div class="">
            <h3 class="text-2xl font-bold">
                ¡Aprovecha los descuentos!
            </h3>
            <div class="inline-flex w-16 h-1 bg-indigo-500 rounded-full"></div>
            <p>
                Nuestras rutas poseen descuento por <strong>compra anticipada</strong>,
                si realizas la compra de su
                boletos con mínimo <strong>10 días de anticipación</strong> podrás obtener estos beneficios.
            </p>
            <br>
            <p>
                Recuerde que estos pasajes están disponibles según
                stock y se agotan rápido, así que planifique su próximo viaje con anticipación.
            </p>
            <a href="{{ route('landing_page.adquirir-pasajes') }}" class="btn bg-white text-primary w-full mt-4">
                Buscar vuelos
            </a>
        </div>
    </div>
</div> --}}

<div style="background: url('{{ asset('img/bg-airplane-1.png') }}');background-size: cover;">
    <div style="background: rgba(30,42,148,.8); padding-top: 80px; padding-bottom: 80px">
        <div class="container mx-auto grid lg:grid-cols-5 items-center gap-8 text-white">
            <div class="col-span-2">
                <img src="{{ asset('img/money-bag.svg') }}" alt="" srcset="" class="rellax" data-rellax-speed="1">
            </div>
            <div class="col-span-3">
                <h3 class="text-2xl font-bold">¡Aprovecha los descuentos!</h3>
                <div class="py-8">
                    <p>
                        Nuestras rutas poseen descuento por <strong>compra anticipada</strong>,
                        si realizas la compra de su
                        boletos con mínimo <strong>10 días de anticipación</strong> podrás obtener estos beneficios.
                    </p>
                    <br>
                    <p>
                        Recuerde que estos pasajes están disponibles según
                        stock y se agotan rápido, así que planifique su próximo viaje con anticipación.
                    </p>
                </div>
                <a href="{{ route('landing_page.adquirir-pasajes') }}" class="btn bg-white text-primary w-full">
                    Buscar vuelos
                </a>
            </div>
        </div>
    </div>
</div>
