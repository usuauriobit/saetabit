<div class="container mx-auto" x-data="registrarPasajeros({ $wire })">
    @if (!$startOk)
        <div class="text-center my-8">
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
    @else
        <div class="grid grid-cols-5 cabecera p-6 gap-4">
            <div class="col-span-3">
                @include('livewire.landing-page.registrar-pasajeros.section-tabs')
                <template x-for="tarifa in $store.adquisicionPasaje.tarifas">
                    <div x-show="tab === tarifa.descripcion" class="pt-4">
                        <div x-show="!$store.adquisicionPasaje.isTarifaCompleted(tarifa)">
                            @include('livewire.landing-page.registrar-pasajeros.form-add-pasajero')
                        </div>
                        <div class="card card-white mt-2">
                            <div class="card-body">
                                <div class="text-h5 font-bold">
                                    <h5>Lista de pasajeros</h5>
                                </div>
                                <div x-show="tarifa.pasajeros.length == 0">
                                    @include('livewire.landing-page.registrar-pasajeros.alert-pasajeros-empty')
                                </div>
                                <template x-for="(pasajero, index) in tarifa.pasajeros" :key="pasajero.uid">
                                    <div>
                                        @include('livewire.landing-page.registrar-pasajeros.item-pasajero')
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="col-span-2">
                <div class="card-white">
                    <div class="card-body">
                        <button class="btn btn-primary w-full"
                            x-bind:disabled="!$store.adquisicionPasaje.hasPasajerosCompleted"
                            wire:loading.attr="disabled" x-on:click="$store.adquisicionPasaje.save($wire)">
                            Registrar pago
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
