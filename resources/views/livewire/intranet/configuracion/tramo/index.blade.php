<div>
    @section('title', __('Tramos'))
    <div class="pt-6">
        <x-master.item label="{{ ucfirst('Tramos') }}" sublabel="Lista de Tramos">
            <x-slot name="actions">
                <a href="#createTramoModal" wire:click="create" class="btn btn-primary"> <i class="la la-plus"></i>
                    Agregar</a>
            </x-slot>
        </x-master.item>
    </div>

    <div class="alert alert-info my-2">
        <div class="flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <label>
                Los registros que ya se encuentren relacionados con datos de
                <strong>Rutas</strong>
                no podrán ser eliminados.
            </label>
        </div>
    </div>

    @include('livewire.intranet.configuracion.tramo.create')
    @include('livewire.intranet.configuracion.tramo.show')

    {{-- <div wire:ignore.self wire:key="mapa" id="map" class="map"></div> --}}
    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="actions">
                    <div class="grid grid-cols-2 gap-4">
                        <x-master.input wire:model.debounce.700ms="search_origen" label="Origen" placeholder="Buscar..." />
                        <x-master.input wire:model.debounce.700ms="search_destino" label="Destino" placeholder="Buscar..." />
                    </div>
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Origen</th>
                        <th>Escala</th>
                        <th>Destino</th>
                        <th>Tiempo de vuelo (min)</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($items as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <x-item.ubicacion :ubicacion="$row->origen" />
                        </td>
                        <td>
                            @if ($row->escala)
                                <x-item.ubicacion :ubicacion="$row->escala" />
                            @endif
                        </td>
                        <td>
                            <x-item.ubicacion :ubicacion="$row->destino" />
                        </td>
                        <td>
                            {{ $row->minutos_vuelo }} min
                        </td>
                        <td class="w-3">
                            <a href="#showTramoModal" wire:click="show({{$row->id}})"
                                class="btn btn-circle btn-sm btn-success">
                                <i class="la la-eye"></i>
                            </a>
                            {{-- <a href="#createTramoModal" wire:click="edit({{$row->id}})"
                                class="btn btn-circle btn-sm btn-warning">
                                <i class="la la-edit"></i>
                            </a> --}}
                            @if ($row->rutas->count() == 0)
                                <button wire:click="destroy({{$row->id}})" class="btn btn-circle btn-sm btn-danger"
                                    onclick="confirm('¿Está seguro de eliminar? No podrá recuperarlo después')||event.stopImmediatePropagation()">
                                    <i class="la la-trash"></i>
                                </button>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>


    {{-- @section('script')
    <script
      src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&callback=initMap&v=weekly&channel=2"
      async
      wire:ignore
    ></script>
    <script
    wire:ignore>
    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 7,
            center: { lat: -6.4267255, lng: -76.4897677 },
            mapTypeId: "terrain",
        });

        var lineSymbol = {
            path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
        };

        var Poly = new Array();

        const coordenadas = @json($this->coordenadas);
        coordenadas.map(function(tramo){
            tramo = tramo.map(function(tram){return {lng: +tram.lng, lat: +tram.lat }})

            let flightPath = new google.maps.Polyline({
                path: tramo,
                geodesic: true,
                strokeColor: "#588bdc",
                strokeOpacity: 1.0,
                strokeWeight: 2,
                icons: [{
                    icon: lineSymbol,
                    offset: '100%'
                }],
            });
            flightPath.setMap(map);
        })

    }
    </script>
    @endsection
    @section('style')
        <style wire:ignore.self>
            .map {
            height: 400px;
            width: 100%;
            }
        </style>

    @endsection --}}
</div>
