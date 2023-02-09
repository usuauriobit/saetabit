<div class="fade-in-fwd">
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

        <div>
            <livewire:intranet.comercial.adquisicion-pasaje.components.form-search-vuelos with-pasaje-abierto-emit
                noCharter />
        </div>
        <div class="lg:col-span-2">
            {{-- <livewire:intranet.comercial.adquisicion-pasaje.components.result-vuelos-founded
            :type="$type"
            :ida-vuelos-founded="$ida_vuelos_founded"
            :vuelta-vuelos-founded="$vuelta_vuelos_founded"
            /> --}}
            @include('livewire.intranet.comercial.adquisicion-pasaje.components.result_vuelos')
        </div>
    </div>
</div>
