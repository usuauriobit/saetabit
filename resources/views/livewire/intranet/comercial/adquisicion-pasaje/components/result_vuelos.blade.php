<div wire:key="selectVuelos" >
    <div class="my-2 tabs tabs-boxed">
        <a class="tab" :class="{ 'tab-active': tab == 'ida' }" @click="tab = 'ida'">
            IDA <div class="ml-2 badge badge-accent">{{count($ida_vuelos_founded)}} resultados</div>
        </a>
        <a x-show="$wire.type_search == 'ida_vuelta'" class="tab" :class="{ 'tab-active': tab == 'vuelta' }" @click="tab = 'vuelta'">
            VUELTA <div class="ml-2 badge badge-accent">{{count($vuelta_vuelos_founded)}} resultados</div>
        </a>
    </div>

    <div x-show="tab == 'ida'" x-transition:enter.duration.500ms>
        @include('livewire.intranet.comercial.adquisicion-pasaje.components.list_vuelos_result', ['type' => 'ida'])
    </div>
    @if ($type_search == 'ida_vuelta')
        <div>
            <div x-show="tab == 'vuelta'" x-transition:enter.duration.500ms>
                @include('livewire.intranet.comercial.adquisicion-pasaje.components.list_vuelos_result', ['type' => 'vuelta'])
            </div>
        </div>
    @endif
</div>
