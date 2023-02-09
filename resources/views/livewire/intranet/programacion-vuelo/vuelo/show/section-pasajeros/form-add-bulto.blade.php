<div>

    <div>
        <x-master.item label="Pasajero" class="my-4 p-4 border-4 border-primary rounded-lg">
            <x-slot name="sublabel">
                {{$pasaje->nombre_short}}
                <div class="badge badge-info">{{ optional($pasaje->tipo_pasaje)->abreviatura }}</div>
            </x-slot>
        </x-master.item>

        @if ($hasTarifas)
            <x-master.select wire:model="tarifa_bulto_id" name="tarifa_bulto_id" label="Tipo" :options="$tarifas_bulto" desc="tipo_bulto_desc"></x-master.select>

            <div class="my-4 p-4 border-4 border-secondary rounded-lg">
                @if (!$this->tarifa_bulto->is_monto_fijo)
                <x-master.item label="Peso máximo permitido">
                    <x-slot name="sublabel">
                        @nro($this->tarifa_bulto->peso_max)
                    </x-slot>
                </x-master.item>
                @endif
                <x-master.item
                    label="{{
                        $this->tarifa_bulto->is_monto_fijo
                            ? 'Monto referencial'
                            : 'Monto por kilogramo excedido'
                    }}">
                    <x-slot name="sublabel">
                        <span class="font-bold text-gray-500">@soles($this->tarifa_bulto->monto_kg_excedido)</span>
                    </x-slot>
                </x-master.item>
            </div>
        @endif

        <x-master.input label="Descripción" wire:model.defer="form.descripcion" name="form.descripcion"/>
        <div class="grid grid-cols-2 gap-4">
            <x-master.input type="number" step="1" label="Cantidad" wire:model.defer="form.cantidad" name="form.cantidad"/>
            <x-master.input type="number" step="0.01"
                label="Peso total {{  optional($this->tarifa_bulto)->is_monto_fijo ? '(Opcional)' : ''}}"
                wire:model="form.peso_total"
                name="form.peso_total"/>
        </div>

        @if ($hasTarifas)
            @if (!$this->tarifa_bulto->is_monto_fijo)
                @if ($this->has_exceso)
                    <x-master.item label="Peso excedido" class="mt-4">
                        <x-slot name="sublabel">
                            @nro($this->peso_excedido) kg
                        </x-slot>
                    </x-master.item>
                    <x-master.item label="Importe por exceso" class="mt-4">
                        <x-slot name="sublabel">
                            <div class="badge badge-primary">
                                @soles($this->monto_exceso)
                            </div>
                        </x-slot>
                    </x-master.item>
                @endif
            @else
                <x-master.input prefix="S/." type="number" step="0.01" label="Importe" wire:model="form.importe" name="form.importe"/>
            @endif
        @endif

        <button
            onclick="confirm('¿Está seguro?') || event.stopImmediatePropagation()"
            wire:click="save"
            wire:loading.attr="disabled"
            class="w-full mt-4 btn btn-primary">
            <div wire:loading>
                @include('components.loader-horizontal-sm')
            </div>
            <div wire:loading.remove>
                <i class="la la-save"></i> &nbsp; Guardar
            </div>
        </button>
    </form>
</div>
