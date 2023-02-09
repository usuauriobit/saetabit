<div class="py-32  hero max-h-96"
    style="background-image: url('{{ $hero['url_bg'] ?? asset('img/banner1.png') }}'); background-size: cover;">
    <!-- container -->
    <div class="hero-content flex-col lg:flex-row-reverse">
        <img style="max-height: 136px" class="floating" src="{{ $hero['url_img'] ?? asset('img/airplane.png') }}" alt=""
            srcset="">
        <div class="text-white ">
            <h1 class="text-5xl font-bold">
                {{ $hero['title'] ?? 'La empresa aérea líder en la amazonía peruana' }}
            </h1>
            <p class="py-6">
                {{ $hero['subtitle'] ?? 'La empresa aérea líder en la amazonía peruana' }}
            </p>
        </div>
    </div>
</div>
