<div>
    <x-master.item class="text-2xl" label="{{ ucfirst('Apertura/Cierre - ' . ($apertura_cierre->caja->descripcion)) }}" sublabel="">
        <x-slot name="actions">
            @can('intranet.caja.caja-apertura-cierre.export')
                <a href="{{ route('intranet.caja.caja-apertura-cierre.export', $apertura_cierre) }}"
                    class="mr-2 btn btn-warning btn-sm" target="_blank">
                    Imprimir
                </a>
            @endcan
            <a href="{{ route('intranet.caja.caja-apertura-cierre.index') }}" class="btn btn-primary btn-sm">Volver</a>
        </x-slot>
    </x-master.item>
    <div class="mt-2 card-white">
        <div class="card-body">
                <div class="grid grid-cols-3 gap-4">
                    <x-master.item class="mb-4" label="Fecha de Apertura" :sublabel="optional($apertura_cierre->fecha_apertura)->format('d-m-Y H:i')"></x-master.item>
                    <x-master.item class="mb-4" label="Fecha de Cierre" :sublabel="optional($apertura_cierre->fecha_cierre)->format('d-m-Y H:i')"></x-master.item>
                    <x-master.item class="mb-4" label="Cajero" :sublabel="$apertura_cierre->user_created->name"></x-master.item>
                    {{-- <x-master.item class="mb-4" label="Caja" :sublabel="$apertura_cierre->caja->descripcion"></x-master.item> --}}
                </div>
        </div>
    </div>
    <div class="mt-3 tabs tabs-boxed">
        <a class="tab {{ $tab == 'resumen' ? 'tab-active' : '' }}" wire:click="setTab('resumen')">Resumen</a>
        <a class="tab {{ $tab == 'denominaciones' ? 'tab-active' : '' }}" wire:click="setTab('denominaciones')">Denominaciones</a>
        <a class="tab {{ $tab == 'movimientos' ? 'tab-active' : '' }}" wire:click="setTab('movimientos')">Movimientos</a>
        <a class="tab" wire:loading>
            @include('components.loader-horizontal-sm')
        </a>
        </div>
    <div class="grid grid-cols-1 gap-4 mt-4 lg:grid-cols-5">
        @if ($tab == 'resumen')
            @include('livewire.intranet.caja.caja-apertura-cierre.components.section-resumen')
        @endif
        @if ($tab == 'denominaciones')
            @include('livewire.intranet.caja.caja-apertura-cierre.components.section-denominaciones')
        @endif
        @if ($tab == 'movimientos')
            @include('livewire.intranet.caja.caja-apertura-cierre.components.section-movimientos')
        @endif
    </div>
    <div class="card-white">
        <div class="card-body">
            <h3 class="card-title">Observaciones</h3>
            <x-master.item class="mb-4" label="" :sublabel="$apertura_cierre->observacion_apertura"></x-master.item>
        </div>
    </div>
</div>
