<x-master.modal id-modal="clienteModal" label="Selecciona un cliente" wSize="2xl">
    <div x-data="{tab: 'clientes'}">
        <div class="w-full tabs tabs-boxed">
            <a class="tab" :class="tab == 'clientes' && 'tab-active'" x-on:click="tab = 'clientes'" >Clientes</a>
            <a class="tab" :class="tab == 'personas' && 'tab-active'" x-on:click="tab = 'personas'" >Personas</a>
        </div>
        <div x-show="tab == 'clientes'">
            @include('livewire.intranet.caja.cuenta-cobrar.components.table-clientes')
        </div>
        <div x-show="tab == 'personas'">
            @include('livewire.intranet.caja.cuenta-cobrar.components.table-personas')
        </div>
    </div>
</x-master.modal>
