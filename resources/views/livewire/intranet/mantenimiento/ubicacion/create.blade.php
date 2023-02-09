<x-master.modal id-modal="createUbicacionModal" label="Registro de ubicacion" w-size="4xl">
    <form wire:submit.prevent="save" class="pb-4">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
            <div class="grid gap-4 lg:grid-cols-2 xs:grid-cols-1">
                <div>
                    @if ($this->ubigeo)
                        <x-master.item
                            label="{{ $this->ubigeo->distrito }}"
                            sublabel='{{ "{$this->ubigeo->provincia}, {$this->ubigeo->departamento}" }}'>
                            <x-slot name="actions">
                                <button type="button" class="btn btn-sm" wire:click="removeUbigeo">
                                    <i class="text-lg la la-close"></i>
                                </button>
                            </x-slot>
                        </x-master.item>
                    @else
                        <livewire:intranet.components.input-ubigeo label="Ubigeo" />
                    @endif
                    <x-master.select name="form.tipo_pista_id" label="Tipo pista" wire:model.defer="form.tipo_pista_id"
                        :options="$tipo_pistas"></x-master.select>
                    <x-master.input name="form.codigo_icao" label="Codigo icao" wire:model.defer="form.codigo_icao" type="text"
                        required></x-master.input>
                    <x-master.input name="form.codigo_iata" label="Codigo iata" wire:model.defer="form.codigo_iata" type="text"></x-master.input>
                    <x-master.input name="form.descripcion" label="Descripcion" wire:model.defer="form.descripcion" type="text"
                        required></x-master.input>
                </div>
                <div>
                    <div class="grid gap-4 mb-3 lg:grid-cols-2 xs:grid-cols-1">
                        {{-- {{var_dump($form)}} --}}
                        <x-master.input name="form.geo_longitud" label="Geo latitud" wire:model="form.geo_longitud" type="text"/>
                        <x-master.input name="form.geo_latitud" label="Geo longitud" wire:model="form.geo_latitud" type="text"/>
                    </div>
                    {{-- <div wire:ignore class="rounded-box" id="mapCreate" style="width:100%; height:400px;"></div> --}}
                </div>
            </div>
        </div>
        <div class="modal-action">
            <a href="#"  class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i>
                Guardar</button>
        </div>
    </form>

    {{-- <script wire:ignore>
        let markerCreate
        let mapCreate
        initCreateMap()
        function initCreateMap() {
            mapCreate = new google.maps.Map(document.getElementById("mapCreate"), {
                center: { lat: -6.5094, lng: -76.367 },
                zoom: 13,
            });
            markerCreate = new google.maps.Marker({
                position: { lat: -6.5094, lng: -76.367 },
                map: mapCreate,
                draggable: true
            });

            google.maps.event.addListener(markerCreate, 'dragend', function(marker) {
                let latLng = marker.latLng;
                @this.set('form.geo_longitud', latLng.lng());
                @this.set('form.geo_latitud', latLng.lat());
            });
        }
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook("element.updated", (el, component) => {
                if(@this.form['geo_latitud']){
                    let newLatLng = new google.maps.LatLng(@this.form['geo_latitud'], @this.form['geo_longitud']);
                    markerCreate.setPosition(newLatLng);
                    mapCreate.setCenter(newLatLng);
                }
            })
        });
    </script> --}}
</x-master.modal>
