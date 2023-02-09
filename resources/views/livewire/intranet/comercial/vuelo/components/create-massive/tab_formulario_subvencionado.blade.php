<div class="p-5 my-3 bg-white shadow-lg rounded-box">
    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        <x-master.input name="form.paquete" wire:model.defer="form.paquete" label="Paquete"></x-master.input>
        <x-master.input name="form.nro_contrato" wire:model.defer="form.nro_contrato" label="Número de contrato">
        </x-master.input>
        <x-master.select name="form.cliente_id" desc="razon_social" :options="$clientes" wire:model.defer="form.cliente_id"
            label="Cliente"></x-master.select>
        <x-master.input type="number" step="0.01" name="form.monto_total" wire:model="form.monto_total"
            label="Monto total">
            <x-slot name="altLabelBL">
                @if (isset($form['monto_total']) && !empty($form['monto_total']))
                    <span label="text-primary">@soles($form['monto_total'])</span>
                @endif
            </x-slot>
        </x-master.input>
    </div>
</div>
