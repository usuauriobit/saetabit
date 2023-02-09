<x-master.modal id-modal="showUbicacionModal" w-size="4xl">

    <div class="grid gap-4 lg:grid-cols-2 xs:grid-cols-1">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
            @if(is_null($ubicacion))
                <div class="loader">Cargando...</div>
            @else
                <div>
                    <div class="col-md-12">
                        <x-master.item class="mb-4" label="Ubigeo" :sublabel="optional($ubicacion->ubigeo)->descripcion">
                        </x-master.item>
                    </div>
                    <div class="col-md-12">
                        <x-master.item class="mb-4" label="Tipo pista"
                            :sublabel="optional($ubicacion->tipo_pista)->descripcion"></x-master.item>
                    </div>
                    <div class="col-md-12">
                        <x-master.item class="mb-4" label="Codigo icao" :sublabel="$ubicacion->codigo_icao"></x-master.item>
                    </div>
                    <div class="col-md-12">
                        <x-master.item class="mb-4" label="Codigo iata" :sublabel="$ubicacion->codigo_iata"></x-master.item>
                    </div>
                    <div class="col-md-12">
                        <x-master.item class="mb-4" label="Descripcion" :sublabel="$ubicacion->descripcion"></x-master.item>
                    </div>
                    <div class="col-md-12">
                        <x-master.item class="mb-4" label="Latitud" :sublabel="$ubicacion->geo_latitud"></x-master.item>
                    </div>
                    <div class="col-md-12">
                        <x-master.item class="mb-4" label="Longitud" :sublabel="$ubicacion->geo_longitud"></x-master.item>
                    </div>
                </div>
            @endif
        </div>
        <div wire:loading.class="hidden">
            <div wire:ignore class="bg-red-500 rounded-box" id="mapShow" style="height: 400px"></div>
        </div>
    </div>
    <div class="modal-action">
        <a href="#" class="btn btn-ghost">Cerrar</a>
    </div>

    <script wire:ignore>
        var markerShow
        var mapShow
        initShowMap(-6.5094, -76.367)
        function initShowMap(lat, lng) {
            mapShow = new google.maps.Map(document.getElementById("mapShow"), {
                center: { lat: parseFloat(lat), lng: parseFloat(lng) },
                zoom: 13,
            });
            markerShow = new google.maps.Marker({
                position: {lat: parseFloat(lat), lng: parseFloat(lng)},
                map: mapShow
            });
        }
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.on('renderMap', coordenadas => {
                initShowMap(coordenadas[0], coordenadas[1])
            })
        });
    </script>

</x-master.modal>
