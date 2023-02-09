<div>
    <x-master.item sublabel="Lista de vuelos continuos en una ruta (Agrupación de registros)">
        <x-slot name="label">
            Vuelos en ruta
            <span class="badge badge-primary">
                {{ optional($vuelo_ruta->vuelos)->count() }}
            </span>
        </x-slot>
        <x-slot name="avatar">
            <i class="las la-braille"></i>
        </x-slot>
    </x-master.item>

    @foreach ($vuelo_ruta->vuelos as $vuelo_r)
        <div class="my-2">
            <x-item.vuelo-horizontal-simple
                wire:key="vueloIda{{$vuelo_r->id}}"
                :vuelos="[$vuelo_r]"
            >
            <a class="btn btn-primary" href="{{ route('intranet.programacion-vuelo.vuelo.show', $vuelo_r) }}">
                <i class="text-xl la la-eye"></i>
            </a>
            </x-item.vuelo-horizontal-simple>
        </div>
        @if (!$loop->last)
            <div class="text-center">
                <i class="text-2xl las la-angle-double-down"></i>
            </div>
        @endif
    @endforeach

</div>
