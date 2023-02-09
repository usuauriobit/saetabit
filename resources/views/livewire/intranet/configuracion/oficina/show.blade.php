<x-master.modal id-modal="showOficinaModal" w-size="4xl">
    <div wire:loading class="w-full">
        <div class="loader">Cargando...</div>
    </div>
    <div wire:loading.remove>
        @if(is_null($oficina))
            <div class="loader">Cargando...</div>
        @else
        <section class="text-gray-600 body-font">
                <h2 class="mb-2 text-lg font-medium text-gray-900 title-font">Información de oficina</h2>
                <div class="avatar">
                    <div class="w-24 rounded">
                      <img src="{{$oficina->image_url}}" />
                    </div>
                  </div>
                <x-master.item no-padding class="mb-4" label="Ubigeo" :sublabel="optional($oficina->ubigeo)->descripcion"></x-master.item>
                <x-master.item no-padding class="mb-4" label="Descripcion" :sublabel="$oficina->descripcion"></x-master.item>
                <x-master.item no-padding class="mb-4" label="Direccion" :sublabel="$oficina->direccion"></x-master.item>
                <x-master.item no-padding class="mb-4" label="Referencia" :sublabel="$oficina->referencia"></x-master.item>
                <x-master.item no-padding class="mb-4" label="Imagen" :sublabel="$oficina->image_url"></x-master.item>
                <x-master.item no-padding class="mb-4" label="Ruta Facturador" :sublabel="$oficina->ruta_facturador"></x-master.item>
                <x-master.item no-padding class="mb-4" label="Token Facturador" :sublabel="$oficina->token_facturador"></x-master.item>
          </section>
        @endif
    </div>

    {{-- <div class="grid gap-4 lg:grid-cols-2 xs:grid-cols-1">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
            @if(is_null($oficina))
                <div class="loader">Cargando...</div>
            @else
                <div>
                    <img src="{{ $oficina->image_url }}" class="w-full h-32">
                    <x-master.item class="mb-4" label="Ubigeo" :sublabel="optional($oficina->ubigeo)->descripcion"></x-master.item>
                    <x-master.item class="mb-4" label="Descripcion" :sublabel="$oficina->descripcion"></x-master.item>
                    <x-master.item class="mb-4" label="Direccion" :sublabel="$oficina->direccion"></x-master.item>
                    <x-master.item class="mb-4" label="Referencia" :sublabel="$oficina->referencia"></x-master.item>
                    <x-master.item class="mb-4" label="Teléfonos" :sublabel="$oficina->telefonos_string"></x-master.item>
                </div>
            @endif
        </div>
        <div wire:loading.class="hidden">
            @if (!is_null($oficina))
                <div class="grid grid-cols-2">
                    <x-master.item class="mb-4" label="Geo latitud" :sublabel="$oficina->geo_latitud"></x-master.item>
                    <x-master.item class="mb-4" label="Geo longitud" :sublabel="$oficina->geo_longitud"></x-master.item>
                </div>
            @endif
            <div wire:ignore class="rounded-box" id="mapShow" style="height: 400px"></div>
        </div>
    </div> --}}
    <div class="modal-action">
        <a href="#" class="btn btn-ghost">Cerrar</a>
    </div>
    <script wire:ignore>
        var markerShow
        var mapShow
        initShowMap(-6.5094, -76.367)

        function initShowMap(lat, lng) {
            mapShow = new google.maps.Map(document.getElementById("mapShow"), {
                center: {
                    lat: parseFloat(lat),
                    lng: parseFloat(lng)
                },
                zoom: 13,
            });
            markerShow = new google.maps.Marker({
                position: {
                    lat: parseFloat(lat),
                    lng: parseFloat(lng)
                },
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
