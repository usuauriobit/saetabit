<div>
    @include('components.alert-errors')

    {{-- SELECCIONAR FECHA Y BUSCAR VUELO --}}
    <div class="shadow-lg alert alert-info">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="flex-shrink-0 w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>
                Se la tarifa del vuelo sustituyente es mayor, el pasajero deberá pagar la diferencia.
                Si la tarifa del vuelo sustituyente es menor, la empresa no transferirá la diferencia.
            </span>
        </div>
    </div>

    @if (!$vuelos_selected)
        <div>
            <div class="mt-2">
                <livewire:intranet.comercial.adquisicion-pasaje.components.form-search-vuelos />

            </div>
            <div>
                <span class="text-lg font-bold mt-2">{{ count($vuelos_founded) }} resultados encontrados</span>
                @foreach ($vuelos_founded as $vuelos)
                    <livewire:intranet.comercial.adquisicion-pasaje.components.item-vuelo-select
                        wire:key="itemFounded{{now()}}"
                        :vuelos="$vuelos"
                        emitEvent="vueloSelectedRuta"
                        :param-emit-event="$vuelos"
                    />
                @endforeach
            </div>
        </div>
    @else
        <div>
            <div class="mt-4 card-white">
                <span class="text-lg font-bold">Vuelo seleccionado</span>
                <x-item.vuelo-horizontal-simple
                    wire:key="vueloSelectedRutaSimple"
                    :vuelos="$this->vuelos_selected_model"
                    transparent
                />
            </div>
            <button type="button" class="w-full mt-4 btn btn-primary btn-outline" wire:click="deleteVuelosSelected">
                <i class="text-lg la la-search"></i> Volver a buscar
            </button>

            @if ($this->tarifa->is_dolarizado)
                <small>Esta tarifa se sujeta a un precio en dolares</small>
                <x-master.item label="Precio de la nueva tarifa (Dólares)" sublabel="{{ $this->tarifa->precio }}" />
                ≈ @soles($this->tarifa->precio_soles)
            @else
                <x-master.item label="Precio de la nueva tarifa (Soles)" sublabel="{{ $this->tarifa->precio }}" />
            @endif
            <div class="badge badge-success">{{ $this->tarifa->descripcion }}</div>

            <x-master.item
                label="Importe adicional">
                <x-slot name="sublabel">
                    @soles($this->importe_adicional)
                </x-slot>
            </x-master.item>
        </div>
    @endif

    <hr class="my-4">
    <div class="my-4">
        <x-master.item label="Importe pagado del pasaje (Solo de referencia, no aplicará ningún cobro actual)">
            <x-slot name="sublabel">
                @soles($this->pasaje->importe_final_soles)
            </x-slot>
        </x-master.item>
    </div>
    <div class="my-4">
        <input type="checkbox" class="toggle" wire:model="is_sin_pagar"> Sin cobro de penalidad
    </div>

    @if (!$is_sin_pagar)
        <x-master.input disabled prefix="S/" type="number" step="0.01" label="Importe de penalidad" wire:model.debounce.500ms="importe_penalidad" name="importe_penalidad" />
        {{-- ≈ @soles($this->monto) --}}
        <x-master.item
            class="my-4 font-bold"
            label="Importe total a pagar">
            <x-slot name="sublabel">
                @soles($this->importe_total)
            </x-slot>

        </x-master.item>
    @else
        @include('livewire.intranet.comercial.pasaje-cambio.components.alert-sin-pago-info')
    @endif

    <x-master.input label="Nota" wire:model.defer="nota" name="nota" />

    @if (!$pasaje->can_cambio_ruta|| $is_sin_pagar)
        @include('components.alert-autorizacion')
        <livewire:intranet.components.modal-password-validation
            :is-modal="false"
            withObservacion
            :shouldCloseModal="false"
            :hasCancelBtn="false"
            permission="intranet.comercial.pasaje.cambio.ruta.create.super"
        />
    @else
        <button onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()" wire:loading.attr="disabled"
            wire:click="saveCambioTitularidad" class="w-full mt-4 btn btn-primary">
            <i class="text-lg la la-save"></i> Guardar
        </button>
    @endif
</div>
