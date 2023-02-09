<div x-show="" class="grid grid-cols-2 gap-4">
    <div class="card-white">
        <div class="card-body">
            <img class="mx-auto h-60" src="{{ asset('img/repo/plane-1.png') }}" alt="">
            <div class="my-4 text-center">
                <strong class="text-xl font-bold">
                    Registrar vuelo
                </strong>
            </div>
            @foreach ($tipos_dont_support_massive->groupBy('categoria_vuelo.descripcion') as $cat => $tipos)
                <strong class="mt-3">{{ $cat }}</strong>
                @foreach ($tipos as $tipo)
                    <a href="{{route('intranet.comercial.vuelo.create-simple', $tipo)}}"  class="my-2 btn btn-outline btn-primary">
                        <span>{{$tipo->descripcion}}</span>
                        <i class="ml-auto la la-arrow-right"></i>
                    </a >
                @endforeach
            @endforeach
        </div>
    </div>
    <div class="card-white">
        <div class="card-body">
            <img class="mx-auto h-60" src="{{ asset('img/repo/plane-2.png') }}" alt="">
            <div class="my-4 text-center">
                <strong class="text-xl font-bold">
                    Programar vuelos
                </strong>
            </div>
            @foreach ($tipos_supports_massive as $tipo)
            <a href="{{route('intranet.comercial.vuelo.create-massive', $tipo)}}"  class="my-2 btn btn-outline btn-primary">
                    <span>{{$tipo->descripcion}}</span>
                    <i class="ml-auto la la-arrow-right"></i>
                </a >
            @endforeach
        </div>
    </div>
</div>
