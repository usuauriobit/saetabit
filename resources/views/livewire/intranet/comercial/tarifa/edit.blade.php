<div>
    {{-- <div class="flex justify-between my-2">
        <div>
            <div class="text-lg font-bold">{{ $tarifa->descripcion }}</div>
            <div class="text-secondary">{{ $tarifa->tipo_pasaje->abreviatura }}</div>
        </div>
        <div class="font-bold text-right text-primary">
            @soles($tarifa->precio)
            <a href="#editarTarifa{{$tarifa->id}}" class="ml-2 btn btn-outline btn-sm">
                <i class="text-lg la la-edit"></i>
            </a>
        </div>
    </div> --}}
    <div>
        <div class="alert alert-info">
            <div class="flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="w-6 h-6 mx-2 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <label>También se cambiará el monto a la ruta de vuelta</label>
            </div>
        </div>
        <div class="my-2 alert alert-info">
            <div class="flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="w-6 h-6 mx-2 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <label>
                    La edición de esta tarifa no tendrá efecto en la lista de pasajes ya registrados
                </label>
            </div>
        </div>
        <x-item.ruta :ruta="$tarifa->ruta" />
        <x-master.item class="my-2" label="{{ optional($tarifa->tipo_pasaje)->descripcion }}"
            sublabel="{{ optional($tarifa->tipo_pasaje)->abreviatura }}"></x-master.item>
        <x-master.input label="Descripción" wire:model="descripcion" />
        @if ($tarifa->is_dolarizado)
            <x-master.input type="number" step="0.01" prefix="$" label="Precio (Dólares)"
                wire:model.debounce.500ms="precio" />
            <span wire:loading.remove>
                ≈ @soles($this->precio_soles)
            </span>
            <div wire:loading>
                @include('components.loader-horizontal-sm')
            </div>
        @else
            <x-master.input type="number" step="0.01" prefix="S/." label="Precio"
                wire:model.debounce.500ms="precio" />
        @endif
        <button wire:click="updateTarifa" class="w-full mt-4 btn btn-primary">
            <i class="text-lg la la-save"></i> Guardar
        </button>
    </div>

</div>
