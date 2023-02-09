<div>
    <x-master.item class="mb-2">
        <x-slot name="avatar">
            @if (!isset($avatar) || is_null($avatar))
                <i class="text-xl font-bold la la-map-marker"></i>
                {{-- <img class="h-10 mx-auto" src="{{asset('img/repo/pin1.png')}}" alt=""> --}}
            @else
                {{$avatar}}
            @endif
        </x-slot>
        <x-slot name="actions">
            {{$actions}}
        </x-slot>
        <x-slot name="label">
            @if (!$hideCodigo)
                <div class="text-lg font-bold text-gray-400">
                    {{-- <span>IATA: {{$ubicacion['codigo_iata']}}</span> &nbsp;&nbsp;&nbsp; --}}
                    <span >{{$ubicacion['codigo_default']}}</span>
                </div>
            @endif
            {{-- <strong class="my-2 text-sm font-semibold text-primary">{{$ubicacion['descripcion']}}</strong> --}}
            <p class="font-bold text-gray-600 text-md">
                {{ $ubicacion[ !$onlyDistrito ?  'ubigeo_desc' : 'distrito' ]}}
            </p>
        </x-slot>
    </x-master.item>
    {{$slot}}
</div>
