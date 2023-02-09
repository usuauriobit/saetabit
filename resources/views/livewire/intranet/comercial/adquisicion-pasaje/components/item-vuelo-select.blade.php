<div>
    <div class="my-2 card-white">
        <div class="flex gap-2">
            <div class="flex-auto">
                <x-item.vuelo-horizontal-simple wire:key="vuelo{{ $this->vuelos_model[0]['id'] }}" :vuelos="$this->vuelos_model"
                    transparent hideAsientosDisponibles="{{ $hideAsientosDisponibles }}"
                    hideCodigo="{{ $hideCodigo }}" />
            </div>
            <div class="flex-none">
                <div class="w-20">
                    <div class="p-2 text-center">
                        @if ($canSelect)
                            @if (!$isAlreadySelected)
                                <button type="button" wire:click="selectVuelo" class="btn btn-primary btn-outline">
                                    <i class="la la-check"></i>
                                </button>
                            @else
                                <i class="font-bold la la-check text-success"></i>
                            @endif
                        @else
                            <i class="font-bold la la-window-close text-error"></i>
                        @endif
                    </div>
                    <div wire:loading>
                        @include('components.loader-horizontal-sm')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
