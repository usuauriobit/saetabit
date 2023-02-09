<div>
    <div>
        @include('components.alert-errors')

        {{-- SELECCIONAR FECHA Y BUSCAR VUELO --}}
        <div class="shadow-lg alert alert-info">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="flex-shrink-0 w-6 h-6 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Se buscará vuelos en la misma ruta con la fecha seleccionada</span>
            </div>
        </div>

        @if (!$vuelos_selected)
            <div>
                <x-master.input label="Ingrese una fecha" type="date" wire:model="fecha_filter" name="fecha_filter">
                </x-master.input>
                <button type="button" class="w-full mt-4 btn btn-primary btn-outline" wire:click="search">
                    <i class="text-lg la la-search"></i> Buscar
                </button>
            </div>
            <div>
                <span class="text-lg font-bold mt-2">{{ count($vuelos_founded) }} resultados encontrados</span>
                @foreach ($vuelos_founded as $vuelos)
                    <livewire:intranet.comercial.adquisicion-pasaje.components.item-vuelo-select
                        wire:key="{{ now() }}" :vuelos="$vuelos" emitEvent="vueloSelectedFecha" :param-emit-event="$vuelos" />
                @endforeach
            </div>
        @else
            <div class="mt-4 card-white">
                <span class="text-lg font-bold">Vuelo seleccionado</span>
                <x-item.vuelo-horizontal-simple wire:key="vueloSelectedFecha" :vuelos="$this->vuelos_selected" transparent />
            </div>
            <button type="button" class="w-full mt-4 btn btn-primary btn-outline" wire:click="deleteVuelosSelected">
                <i class="text-lg la la-search"></i> Volver a buscar
            </button>
        @endif

        <div class="my-4">
            <input type="checkbox" class="toggle" wire:model="is_sin_pagar"> Sin cobro de penalidad
        </div>

        @if (!$is_sin_pagar)
            <x-master.input disabled prefix="S/." type="number" step="0.01" label="Importe de penalidad"
                wire:model.debounce.500ms="monto" name="importe_penalidad" />
        @endif
        <div>
            <x-master.input label="Nota" wire:model.defer="nota" name="nota" />
        </div>

        @if (!$pasaje->can_cambio_fecha || $is_sin_pagar)
            @include('components.alert-autorizacion')
            <livewire:intranet.components.modal-password-validation
                :is-modal="false"
                withObservacion
                :shouldCloseModal="false"
                :hasCancelBtn="false"
                permission="intranet.comercial.pasaje.cambio.fecha.create.super"
            />
        @else
            <button onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()" wire:loading.attr="disabled"
                wire:click="saveCambioTitularidad" class="w-full mt-4 btn btn-primary">
                <i class="text-lg la la-save"></i> Guardar
            </button>
        @endif

    </div>
</div>
