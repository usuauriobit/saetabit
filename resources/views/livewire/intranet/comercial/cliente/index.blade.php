<div>
    @section('title', __('Clientes'))
    <div class="cabecera p-6">
        <x-master.item label="Relación de clientes" sublabel="Lista de personas/empresas que han realizado compras">
            <x-slot name="actions">
                <div class="flex items-end grid grid-cols-3 gap-4">
                    <x-master.select wire:model="tipo_documento_id" label="Tipo de Documento" :options="$tipo_documentos" />
                    <x-master.input label="N° Documento" placeholder="" name="nro_documento" wire:model.debounce.700ms="nro_documento"></x-master.input>
                    <x-master.input label="Nombre/Razón Social" placeholder="Buscar nombre ..." name="search" wire:model.debounce.700ms="search"></x-master.input>
                </div>
            </x-slot>
        </x-master.item>
    </div>
    <div class="tabs tabs-boxed mt-3">
        <a class="tab {{ $tab == 'personas' ? 'tab-active' : '' }}" wire:click="setTab('personas')">Personas</a>
        <a class="tab {{ $tab == 'empresas' ? 'tab-active' : '' }}" wire:click="setTab('empresas')">Empresas</a>
      </div>
    <div class="gap-4">
        @if ($tab == 'personas')
            @include('livewire.intranet.comercial.cliente.components.section-persona')
        @endif
        @if ($tab == 'empresas')
            @include('livewire.intranet.comercial.cliente.components.section-empresa')
        @endif
    </div>
</div>
