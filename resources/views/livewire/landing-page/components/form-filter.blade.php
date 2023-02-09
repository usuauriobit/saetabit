<div class="px-10 bg-white rounded-lg shadow-lg py-11">
    <div class="container mx-auto">
        @if ($redirectable)
            <h4 class="mb-6 text-2xl font-bold text-gray-700">¿A dónde quieres ir?</h4>
        @endif
        <form wire:submit.prevent="search">
            <div class="gap-4 mb-3 md:grid md:grid-cols-2 lg:flex lg:justify-start">
                <div class="lg:w-56">
                    @include('livewire.landing-page.components.input-ida-vuelta')
                </div>
                <div class="lg:w-56">
                    @include('livewire.landing-page.components.input-nro-pasajes')
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-4 place-content-end">
                @include('livewire.landing-page.components.input-ubicacion', [
                    'label' => 'Lugar de origen',
                    'placeholder' => 'Seleccione el lugar de origen',
                    'ubicacions' => $ubicaciones_origen,
                    'eventName' => 'setOrigen',
                    'ubicacion' => $ubicacion_origen,
                ])
                @include('livewire.landing-page.components.input-ubicacion', [
                    'label' => 'Lugar de destino',
                    'placeholder' => 'Seleccione el lugar de destino',
                    'ubicacions' => $this->ubicaciones_destino,
                    'eventName' => 'setDestino',
                    'ubicacion' => $ubicacion_destino,
                ])
                @include('components.form_filter.input_date_range')

                <div class="w-full place-self-end" style="z-index:1">
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full px-4 py-3 mr-6 font-bold text-blue-500 transition duration-300 ease-in-out border-2 border-blue-500 rounded-lg hover:bg-blue-500 hover:text-white">
                        <div wire:loading style="margin-left: -40pt">
                            @include('components.loader-horizontal-sm', ['color' => 'rgba(59, 130, 246)'])
                        </div>
                        <div wire:loading.remove>
                            <i class="la la-search"></i> &nbsp; Buscar vuelos
                        </div>
                    </button>
                </div>
            </div>
        </form>
    </div>
    {{-- <i class="las la-plane text-primary md:block hidden rellax"
        data-rellax-speed="-1"
        style="font-size: 270px; z-index:0; transform: rotate(-45deg); position: absolute; opacity: 0.3; margin-top: -20px; margin-left: 80%"></i> --}}
</div>
