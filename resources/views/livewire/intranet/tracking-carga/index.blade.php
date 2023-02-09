<div>

    <livewire:intranet.tracking-carga.components.form-search-carga/>

    <div class="grid grid-cols-1 gap-4 mt-4 lg:grid-cols-5 p-6">
        <div class="lg:col-span-3">
            <span class="my-4 text-lg font-bold">RESULTADOS</span>

            @if ($guia_despacho_founded)
                <livewire:intranet.tracking-carga.components.track-section wire:key="{{ now() }}" :guia-despacho="$guia_despacho_founded"/>
            @else
                <div class="text-center alert alert-info">
                    Sin resultados
                </div>
            @endif

        </div>
        <div class="card-white lg:col-span-2">
            <div class="card-body">
                <span class="text-lg font-bold">Oficinas</span>

                <p class="my-3 text-gray-400">Oficinas autorizadas con su usuario:</p>

                @foreach (Auth::user()->oficinas as $oficina)
                    <div class="flex items-center justify-between">
                        <div class="flex-initial">
                            <strong>
                                {{$oficina->descripcion}}
                            </strong>
                            <p>
                                {{$oficina->ubigeo->descripcion}}
                            </p>
                        </div>
                        <div class="flex-none w-14 ">
                            {{-- <a href="{{route('intranet.tracking-carga.guia-despacho.index', ['oficina_id' => $oficina->id])}}" class="mb-1 btn btn-sm btn-success">
                                <i class="la la-eye"></i>
                            </a> --}}
                            @can('intranet.tracking-carga.guia-despacho.create')
                                <a href="{{route('intranet.tracking-carga.guia-despacho.create', ['oficina_id' => $oficina->id])}}" class="btn btn-sm btn-primary">
                                    <i class="la la-plus"></i>
                                </a>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
