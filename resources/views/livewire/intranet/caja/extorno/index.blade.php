<div>
    <x-master.item label="Extorno de Movimientos" class="col-span-3 my-4">
        <x-slot name="sublabel">

        </x-slot>
        <x-slot name="actions">

        </x-slot>
    </x-master.item>
    <div class="tabs tabs-boxed mt-3">
        <a class="tab {{ $tab == 'solicitud' ? 'tab-active' : '' }}" wire:click="setTab('solicitud')">Solicitudes</a>
        <a class="tab {{ $tab == 'extorno' ? 'tab-active' : '' }}" wire:click="setTab('extorno')">Extornos</a>
        <a class="tab" wire:loading>
            @include('components.loader-horizontal-sm')
        </a>
      </div>
    <div class="grid grid-cols-1 gap-4 mt-4 lg:grid-cols-5">
        @if ($tab == 'solicitud')
            @include('livewire.intranet.caja.extorno.components.section-solicitud')
        @endif
        @if ($tab == 'extorno')
            @include('livewire.intranet.caja.extorno.components.section-extorno')
        @endif
    </div>
</div>
