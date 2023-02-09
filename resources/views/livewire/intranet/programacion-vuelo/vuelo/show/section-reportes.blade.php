<div>
    <div class="card-white">
        <div class="card-body">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <div class="p-3">
                        <span class="text-lg font-bold">Preliminares</span>
                    </div>
                    @if (!$vuelo->is_closed)
                        <ul class="border-2 border-sky-500 rounded-box">
                            @foreach ($preliminares as $preliminar)
                                <li class="flex items-center justify-between p-2 rounded-box hover:bg-gray-50 ">
                                    {{$preliminar['desc']}}
                                    <a target="_blank" href="{{ $preliminar['route'] }}" class="btn btn-circle btn-outline btn-info" >
                                        <i class="text-xl la la-download"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="mx-4 shadow-lg alert alert-info">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="flex-shrink-0 w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>El vuelo se encuentra cerrado</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div>
                    <div class="p-3">
                        <span class="text-lg font-bold">Manifiestos</span>
                    </div>
                    @if (optional($vuelo->tripulacion_vuelo)->count() > 0 && $vuelo->avion)
                        <div class="border-2 border-sky-500 rounded-box">
                            <ul class="">
                                @foreach ($manifiestos as $manifiesto)
                                    <li class="flex items-center justify-between p-2 rounded-box hover:bg-gray-50 ">
                                        {{$manifiesto['desc']}}
                                        <a target="_blank" href="{{ $manifiesto['route'] }}" class="btn btn-circle btn-outline btn-success" >
                                            <i class="text-xl la la-download"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="shadow-lg alert alert-info">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="flex-shrink-0 w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span> Debe </span>haber registro de tripulación y avión para continuar
                            </div>
                        </div>
                    @endif

                    @if ($vuelo->hora_despegue)
                        <div class="border-2 border-sky-500 rounded-box">
                            <ul class="">
                                <li class="flex items-center justify-between p-2 rounded-box hover:bg-gray-50 ">
                                    Resumen de vuelo
                                    <a target="_blank" href="{{ route('intranet.programacion-vuelo.vuelo.export.manifiesto-resumen.pdf', ['vuelo' => $this->vuelo]) }}" class="btn btn-circle btn-outline btn-success" >
                                        <i class="text-xl la la-download"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="shadow-lg alert alert-info">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="flex-shrink-0 w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Debe registrar la hora de despegue para continuar</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
