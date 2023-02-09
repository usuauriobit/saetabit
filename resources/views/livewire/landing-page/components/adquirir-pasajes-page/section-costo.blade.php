<div x-data>
    <div class="card-white">
        <div class="card-body">
            <strong class="text-gray-600">IDA</strong>
            @include('livewire.landing-page.components.adquirir-pasajes-page.section-costo.item-type-detalle',
                ['type' => 'ida'])
            <hr class="my-4">

            @if ($is_ida_vuelta)
                <strong class="text-gray-600">VUELTA</strong>
                @include('livewire.landing-page.components.adquirir-pasajes-page.section-costo.item-type-detalle',
                    ['type' => 'vuelta'])
                <hr class="my-4">
            @endif
            <span class="font-bold text-gray-400">Monto total</span>
            <div class="text-2xl font-bold text-primary">
                @soles($this->monto_total)
            </div>
            <div class="pt-4">
                @if ($this->can_continuar)
                    <button wire:loading.attr="disabled" class="w-full btn-primary btn" wire:click="continue">
                        Continuar
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
