<div class="px-10 bg-white rounded-lg shadow-lg py-11" >
    <div class="container mx-auto">
        <h4 class="mb-6 text-2xl font-bold text-gray-700">¿A dónde quieres ir?</h4>
        <form wire:submit.prevent="search">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                {{-- <livewire:intranet.comercial.vuelo.components.input-ubicacion
                    label="Ingresa el origen"
                    onlyAllowed
                />
                <livewire:intranet.comercial.vuelo.components.input-ubicacion
                    label="Ingresa el destino"
                    onlyAllowed
                /> --}}
                {{-- @include('components.form_filter.ciudad_input', [
                    'label' => 'Lugar de origen',
                    'placeholder' => 'Escriba el lugar de origen',
                    'is_origen' => true
                ])
                @include('components.form_filter.ciudad_input', [
                    'label' => 'Lugar de destino',
                    'placeholder' => 'Escriba el lugar de destino',
                    'is_origen' => false
                ]) --}}
                @include('components.form_filter.input_date_range')

                <div class="w-full place-self-end">
                    <button type="submit" wire:loading.attr="disabled" class="w-full px-4 py-3 mr-6 font-bold text-blue-500 transition duration-300 ease-in-out border-2 border-blue-500 rounded-lg hover:bg-blue-500 hover:text-white">
                        <i class="la la-search"></i> Buscar vuelos
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
