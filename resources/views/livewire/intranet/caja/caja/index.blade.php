<div>
    <div>
        @section('title', __('Cajas'))
    </div>

    <div class="p-6">
        @foreach ($items->groupBy('oficina.descripcion') as $oficina => $cajas)
            <div class="p-4 text-xl badge badge-primary">{{$oficina}}</div>

            <div class="grid grid-cols-3 gap-4 my-4">
                @foreach ($cajas as $caja)
                <div class="card-white compact side bg-base-100">
                    <div class="flex-row items-center space-x-4 card-body">
                        <div class="flex-1">
                            <h2 class="card-title">{{ $caja->descripcion }}</h2>
                            <p class="text-base-content text-opacity-40">{{ $oficina }}</p>
                        </div>
                        <div class="flex-0">
                            @can('intranet.caja.caja.show')
                                <a href="{{ route('intranet.caja.caja.show', $caja) }}" class="transform btn btn-sm motion-safe:hover:scale-105">
                                    Ingresar &nbsp;
                                    <i class="text-xl la la-arrow-right"></i>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endforeach
    </div>

</div>
