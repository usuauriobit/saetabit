<div>
    <form wire:submit.prevent="save">
        <div wire:loading>
            @include('components.loader-horizontal-sm')
        </div>
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            <x-master.select label="Tipo de Pago" name="form.tipo_pago_id" wire:model.prevent="form.tipo_pago_id" :options="$tipo_pagos" wire:change="selectTipoPago" />
            <x-master.input label="Fecha Pago" type="date" name="form.fecha_pago" wire:model.defer="form.fecha_pago" readonly />
        </div>
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                @if ($this->tipo_pago_desc == 'Crédito')
                    <x-master.input label="Fecha Inicio Pago" type="date" name="form.fecha_credito" wire:model.defer="form.fecha_credito"/>
                    <x-master.input label="N° Cuotas" type="number" step="1" name="form.nro_cuotas" wire:model="form.nro_cuotas" />
                @endif
            </div>
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            @if ($this->tipo_pago_desc == 'Tarjeta de Crédito o Débito')
                <x-master.select label="Tarjeta" name="form.tarjeta_id" wire:model.defer="form.tarjeta_id" :options="$tarjetas" />
                <x-master.input label="Cargo (%)" type="number" step="0.01" name="form.porcentaje_cargo" wire:model.debounce.700ms="form.porcentaje_cargo" />
            @endif
        </div>
        <div class="grid grid-cols-2 gap-4">
            @if ($this->tipo_pago_desc == 'Transferencia Bancaria')
                <x-master.select label="Cuenta Bancaria" name="form.cuenta_bancaria_id" wire:model.defer="form.cuenta_bancaria_id" :options="$cuentas_bancarias" desc="descripcion_completa" />
                <x-master.input label="N° Operación" type="number" name="form.nro_operacion" wire:model.defer="form.nro_operacion" />
            @endif
        </div>
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            <x-master.input label="Importe (S/.)" type="number" step="0.01" name="form.monto" wire:model.debounce.700ms="form.monto" />
            <div class="stat">
                <div class="stat-title font-bold">Total</div>
                <div class="stat-value">@soles($this->total)</div>
            </div>
            <div class="stat">
                <div class="stat-title font-bold">Por Ingresar</div>
                <div class="stat-value">@soles(optional($this->venta ?? null)->saldo_por_ingresar ?? 0)</div>
              </div>
        </div>
        <button class="w-full mt-2 btn btn-success btn-sm">Guardar</button>
    </form>
</div>
