<div>
    <div class="grid grid-cols-3 gap-4">
        <div class="card-white">
            <div class="p-2"
                style="background-image: url('{{ asset('img/default/colorful10.jpg') }}'); background-position:; background-repeat: no-repeat; background-size: cover;"
            >
                <div class="card-white">
                    <div class="card-body">
                        <div class="flex justify-between items-center gap-4">
                            <span class="text-h4"><strong>{{ optional($pasaje_cambio_tarifa->categoria_vuelo)->descripcion }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <x-master.input
                    type="number"
                    step="0.01"
                    label="Monto por cambio de fecha"
                    value="{{ old('monto_cambio_fecha', $pasaje_cambio_tarifa->monto_cambio_fecha) }}"
                    wire:model="form.monto_cambio_fecha" />
                <x-master.input
                    type="number"
                    step="0.01"
                    label="Monto por fecha abierta"
                    value="{{ old('monto_cambio_abierto', $pasaje_cambio_tarifa->monto_cambio_abierto) }}"
                    wire:model="form.monto_cambio_abierto" />
                <x-master.input
                    type="number"
                    step="0.01"
                    label="Monto por cambio de titularidad"
                    value="{{ old('monto_cambio_titularidad', $pasaje_cambio_tarifa->monto_cambio_titularidad) }}"
                    wire:model="form.monto_cambio_titularidad" />
                <x-master.input
                    type="number"
                    step="0.01"
                    label="Monto por cambio de ruta"
                    value="{{ old('monto_cambio_ruta', $pasaje_cambio_tarifa->monto_cambio_ruta) }}"
                    wire:model="form.monto_cambio_ruta" />

                <button class="btn btn-primary full-width mt-4" wire:click="save" onclick="confirm('¿Está seguro de extornar? No podrá recuperarlo después')||event.stopImmediatePropagation()">
                    <i class="la la-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>
