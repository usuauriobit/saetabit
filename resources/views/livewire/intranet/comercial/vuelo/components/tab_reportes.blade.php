<div>
    @php
        $preliminares = [
            [
                'desc' => 'Lista preliminar de pasajeros',
                'type' => 'preliminar_pasajeros'
            ],
            [
                'desc' => 'Lista preliminar de cargas',
                'type' => 'preliminar_cargas'
            ],
        ];
        $manifiestos = [
            [
                'desc' => 'Manifiesto de pasajeros',
                'type' => 'manifiesto_pasajeros'
            ],
            [
                'desc' => 'Manifiesto de cargas',
                'type' => 'manifiesto_cargas'
            ],
            [
                'desc' => 'Resumen de vuelo',
                'type' => 'resumen_vuelo'
            ],
        ];
    @endphp

    <div class="card-white">
        <div class="card-body">
            <div class="grid grid-cols-2 gap-4">
                <div class="border-2 border-sky-500 rounded-box">
                    <div class="p-3">
                        <span class="text-lg font-bold">Preliminares</span>
                    </div>
                    <ul class="divide-y-2 divide-gray-400">
                        @foreach ($preliminares as $preliminar)
                            <li class="flex items-center justify-between p-3 rounded-box hover:bg-gray-50">
                                {{$preliminar['desc']}}
                                <button wire:click="print('{{$preliminar['type']}}')" class="btn btn-circle btn-info" >
                                    <i class="text-xl la la-download"></i>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <div class="p-3">
                        <span class="text-lg font-bold">Manifiestos</span>
                    </div>
                    @if (!$vuelo->is_closed)
                        <div class="shadow-lg alert alert-info">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="flex-shrink-0 w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span> Debe cerrar el vuelo para generar los manifiestos y resumen de vuelo</span>
                            </div>
                        </div>
                    @else
                        <div class="border-2 border-sky-500 rounded-box">
                            <ul class="divide-y-2 divide-gray-400">
                                @foreach ($manifiestos as $manifiesto)
                                    <li class="flex items-center justify-between p-3 rounded-box hover:bg-gray-50">
                                        {{$manifiesto['desc']}}
                                        <button wire:click="print('{{$manifiesto['type']}}')" class="btn btn-circle btn-success" >
                                            <i class="text-xl la la-download"></i>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
