<div class="my-4 text-xl font-bold">Monitorio general</div>

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
    <div class="p-4 card-white bg-gray-50">
        <x-widget1 icon="" title="Nro de asientos ofertados">
            <x-slot name="value">
                @if ($vuelo->nro_asientos_ofertados == 0)
                    <div class="text-md">No se registró</div>
                @else
                    {{ $vuelo->nro_asientos_ofertados }}
                @endif
            </x-slot>
            <x-slot name="icon">
                <i class="text-4xl las la-couch text-info"></i>
            </x-slot>
        </x-widget1>
    </div>
    <div class="p-4 card-white bg-gray-50">
        <x-widget1 icon="" title="Nro de pasajes" value="{{ $vuelo->pasajes->count() }}">
            <x-slot name="icon">
                <i class="text-4xl las la-users text-info"></i>
            </x-slot>
        </x-widget1>
    </div>
    <div class="p-4 card-white bg-gray-50">
        <x-widget1 icon="" title="Guías de despacho" value="{{ optional($vuelo->guias_despacho_vuelo)->count() }}">
            <x-slot name="icon">
                <i class="text-4xl las la-boxes text-info"></i>
            </x-slot>
        </x-widget1>
    </div>
</div>

