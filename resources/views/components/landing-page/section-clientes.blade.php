@php
$logos = ['img/logo-del-espino-grey.png', 'img/logo-don-pollo-grey.png', 'img/logo-prosegur-grey.png', 'img/logo-romero-grey.png'];
@endphp
<div class="bg-gray-100" style="padding-top: 100px; padding-bottom: 100px;">
    <div class="text-center" style="margin-bottom: 60px">
        <h3 class="text-2xl font-bold">Ellos confían en nuestros servicios de calidad</h3>
    </div>
    <div class="container mx-auto grid lg:grid-cols-4 items-center justify-between gap-4 text-white">

        @foreach ($logos as $logo)
            <div class="text-center px-auto justify-self-center">
                <img class="text-center" src="{{ asset($logo) }}" alt="">
            </div>
        @endforeach
    </div>
</div>
