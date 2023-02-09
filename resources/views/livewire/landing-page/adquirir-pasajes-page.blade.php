<div class="bg-gray-50" x-data>
    <livewire:landing-page.components.form-filter wire:key="formFilterVuelos" :ubicacion_origen="$ubicacion_origen" :ubicacion_destino="$ubicacion_destino"
        :is_ida_vuelta="$is_ida_vuelta" :fecha_ida="$fecha_ida" :fecha_vuelta="$fecha_vuelta" :nro_pasajes="$nro_pasajes" />

    @if (!$fecha_ida)
        <div class="text-center" style="padding-top: 120px; padding-bottom: 180px">
            <i class="las la-search text-6xl"></i>
            <div class="text-xl font-bold my-2">
                Realice la búsqueda de vuelos disponibles
            </div>
            <p>
                Ingrese un lugar de origen
            </p>
        </div>
    @else
        @if (!$hasError)
            @include('livewire.landing-page.components.adquirir-pasajes-page.tab-search-vuelo')
        @else
            <div class="text-center" style="padding-top: 120px; padding-bottom: 120px">
                <i class="las la-exclamation text-6xl"></i>
                <div class="text-xl font-bold my-2">
                    ¡Ups! Ha ocurrido un error
                </div>
                <p>
                    {{ $errorMsg }}
                </p>
                <a href="{{ route('landing_page.adquirir-pasajes') }}" class="btn btn-primary btn-outline mt-6">
                    <i class="la la-search mr-2"></i> Volver a realizar búsqueda
                </a>
            </div>
        @endif
    @endif
</div>
