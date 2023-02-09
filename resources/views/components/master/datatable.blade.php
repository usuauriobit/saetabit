<div>
    <x-master.item label="Lista" class="pb-3">
        <x-slot name="sublabel">
            <span class="font-weight-bold ms-1">{{ $items->count() }}</span> de {{ $items->total() }} resultados
        </x-slot>
        <x-slot name="avatar">
            <i class="text-2xl la la-list"></i>
        </x-slot>
        <x-slot name="actions">
            @isset($actions)
                {{ $actions }}
            @else
                <x-master.input placeholder="Buscar ..." name="search" wire:model.debounce.700ms="search"></x-master.input>
            @endisset
        </x-slot>
    </x-master.item>

    <div class="mt-2 overflow-x-auto">
        <table class="table {{ isset($compact) ? $compact : '' }} w-full">
            <thead>
                {{ $thead }}
            </thead>
            <tbody>
                {{ $tbody }}
            </tbody>
        </table>
    </div>

    <div class="div">
        {{ $items->links() }}
    </div>
</div>
