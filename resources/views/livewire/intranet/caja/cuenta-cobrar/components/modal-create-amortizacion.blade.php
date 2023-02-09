<x-master.modal id-modal="addAmortizacionModal" label="Registrar amortización">
    <div x-data="{tab: 'form'}">
        <div class="w-full tabs tabs-boxed">
            <a class="tab" :class="tab == 'form' && 'tab-active'" x-on:click="tab = 'form'" >Formulario</a>
            <a class="tab" :class="tab == 'cuentas' && 'tab-active'" x-on:click="tab = 'cuentas'" >Cuentas referenciales</a>
        </div>
        <div x-show="tab == 'form'">
            <x-master.input label="Fecha de pago" type="date" wire:model.defer="form.fecha_pago" name="form.fecha_pago" />
            <x-master.input prefix="S/" label="Monto" wire:model.defer="form.monto" name="form.monto" type="number" />
            <x-master.input label="Nro de cuenta" wire:model.defer="form.nro_cuenta" name="form.nro_cuenta" />
            <x-master.input label="Descripción de cuenta" wire:model.defer="form.descripcion_cuenta" name="form.descripcion_cuenta" />
            <x-master.input label="Glosa" wire:model.defer="form.glosa" name="form.glosa" />
        </div>
        <div x-show="tab == 'cuentas'">
            @foreach ($cuentas_bancarias as $cuenta)
                <x-master.item class="my-3" :label="$cuenta->nro_cuenta" :sublabel="$cuenta->descripcion_completa">
                    <x-slot name="avatar">
                        <i class="la la-credit-card"></i>
                    </x-slot>
                    <x-slot name="actions">
                        <button wire:loading.attr="disabled" type="button" class="btn btn-primary btn-outline btn-sm" @click="tab = 'form'" wire:click="seleccionarCuenta({{$cuenta->id}})">
                            <i class="las la-paste"></i>
                            Seleccionar
                        </button>
                    </x-slot>
                </x-master.item>
            @endforeach
        </div>
    </div>
    <button class="btn btn-primary w-full mt-4"
        wire:click="saveNewAmortizacion"
        onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()">
        <i class="la la-save"></i> &nbsp; Guardar
    </button>
</x-master.modal>
