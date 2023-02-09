<x-master.item sublabel="Lista de vuelos continuos en una ruta (Agrupación de registros)">
    <x-slot name="label">
        Vuelos en ruta
        @if (optional(optional($vuelo->vuelo_ruta)->vuelos)->count() > 1)
            <span class="badge badge-primary">
                {{optional(optional($vuelo->vuelo_ruta)->vuelos)->count()}}
            </span>
        @endif
    </x-slot>
    <x-slot name="avatar">
        <i class="las la-braille"></i>
    </x-slot>
    <x-slot name="actions">
        @if (optional(optional($vuelo->vuelo_ruta)->vuelos)->count() > 1)
            <a class="btn btn-primary" href="{{ route('intranet.programacion-vuelo.vuelo-ruta.show', $vuelo->vuelo_ruta) }}">
                <i class="text-xl la la-eye"></i> &nbsp; Ver vuelos por ruta
            </a>
        @endif
    </x-slot>
</x-master.item>

@if (optional(optional($vuelo->vuelo_ruta)->vuelos)->count() > 1)
    @foreach ($vuelo->vuelo_ruta->vuelos as $vuelo_r)
        <div class="my-2"  key="VueloR{{$vuelo->id}}">
            <div class="{{$vuelo_r->id == $vuelo->id ? 'rounded-lg border-4 border-primary' : ''}} my-2">
                <x-item.vuelo-horizontal-simple
                    wire:key="vueloIda{{$vuelo_r->id}}"
                    :vuelos="[$vuelo_r]"
                >
                    @if ($vuelo_r->id !== $vuelo->id)
                        <a class="btn btn-primary" href="{{ route('intranet.programacion-vuelo.vuelo.show', $vuelo_r) }}">
                            <i class="text-xl la la-eye"></i>
                        </a>
                    @endif
                </x-item.vuelo-horizontal-simple>
            </div>
        </div>
        @if (!$loop->last)
            <div class="text-center">
                <i class="text-2xl las la-angle-double-down"></i>
            </div>
        @endif
    @endforeach
@else
    <div class="p-6 text-center bg-gray-50">
        <strong>No hay vuelos relacionados aquí</strong>
    </div>
@endif
