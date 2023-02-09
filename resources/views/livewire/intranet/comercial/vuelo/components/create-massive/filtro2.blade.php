<div class="p-4 bg-white shadow-lg rounded-box">
    <div class="flex items-end mb-8">
        <div class="w-96">
            <livewire:intranet.comercial.vuelo.components.input-ruta :tipo_vuelo_id="$tipo_vuelo->id" :origen_id="optional(optional(auth()->user()->personal)->oficina)->ubigeo_id"/>
        </div>
        <div class="ml-4" x-show="$wire.ruta">
            <div class="form-control">
                <label class="cursor-pointer label">
                    <input type="checkbox" wire:model="idaVuelta" wire:change="setRutaVuelta" class="toggle">
                    <span class="ml-4 label-text">Ida y vuelta</span>
                </label>
            </div>
        </div>
    </div>
    <div x-show="$wire.idaVuelta" class="mb-2">
        <span class="text-lg font-black ">IDA</span>
    </div>
    <div class="grid grid-cols-1 gap-4 mb-8 lg:grid-cols-3">
        @include('livewire.intranet.comercial.vuelo.components.create-massive.section-origen')
        @include('livewire.intranet.comercial.vuelo.components.create-massive.section-escala')
        @include('livewire.intranet.comercial.vuelo.components.create-massive.section-destino')
        {{-- {{var_dump($vuelos['ida']['origen']['ubicacion']['ubigeo_desc'])}} --}}
    </div>
    <div x-show="$wire.idaVuelta" >
        <div class="mb-2">
            <span class="text-lg font-black ">VUELTA</span>
        </div>
        <div class="grid grid-cols-1 gap-4 mb-8 lg:grid-cols-3">
            @include('livewire.intranet.comercial.vuelo.components.create-massive.section-vuelta-origen')
            @include('livewire.intranet.comercial.vuelo.components.create-massive.section-vuelta-escala')
            @include('livewire.intranet.comercial.vuelo.components.create-massive.section-vuelta-destino')
        </div>
    </div>
</div>
