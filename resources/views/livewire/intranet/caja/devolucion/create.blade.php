<div>
    @section('title', __('Devoluciones'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Nueva Devolución') }}" sublabel="Devoluciones">
            <x-slot name="actions">
                <a class="btn btn-primary btn-sm" href="{{ route('intranet.caja.devolucion.index') }}">
                    Volver
                </a>
            </x-slot>
        </x-master.item>
        <div class="grid grid-cols-4 gap-4 mt-2">
            <div class="card-white">
                <div class="card-body">
                    <h3 class="card-title mt-2 ml-4">Datos del Servicio</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <x-master.item label="Venta N°" sublabel="{{ $venta_detalle->venta->codigo }}"/>
                        <x-master.item label="Comprobante N°" sublabel="{{ $venta_detalle->venta->correlativo_completo }}"/>
                    </div>
                    <x-master.item class="mt-2" label="N° Doc" sublabel="{{ optional($venta_detalle->venta ?? null)->nro_documento ?? '-' }}"/>
                    <x-master.item class="mt-2" label="Cliente" sublabel="{{ optional($venta_detalle->venta->clientable ?? null)->nombre_completo ?? '-' }}"/>
                    <x-master.item class="mt-2" label="Descripción" sublabel="{{ $venta_detalle->descripcion ?? '-' }}"/>
                    <div class="grid grid-cols-2 gap-4">
                        <x-master.item class="mt-2" label="Tipo Servicio" sublabel="{{ $venta_detalle->tipo_servicio ?? '-' }}"/>
                        <x-master.item class="mt-2" label="Fecha" sublabel="{{ $venta_detalle->venta->created_at->format('Y-m-d') }} "/>
                    </div>
                    <x-master.item class="mt-2" label="Importe" sublabel="{{ 'S/. ' . number_format($venta_detalle->importe, 2, '.', ',') }} "/>
                </div>
            </div>
            <div class="card-white col-span-3">
                <form wire:submit.prevent="save">
                    <div class="card-body">
                        <h3 class="card-title mt-2 ml-4">Datos de la Devolución</h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <x-master.select label="Motivo" name="form.devolucion_motivo_id" wire:model.defer="form.devolucion_motivo_id" :options="$motivos" />
                            </div>
                            <x-master.input label="Fecha" type="date" name="form.fecha" wire:model.defer="form.fecha"/>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <x-master.input label="Importe" type="number" step="0.01" name="form.importe" wire:model="form.importe"/>
                            <x-master.input label="Gastos Administrativos" type="number" step="0.01" name="form.gastos_administrativos" wire:model="form.gastos_administrativos"/>
                            <h5 class="text-xl text-center mt-5">
                                Importe a Devolver <br>
                                <span class="badge badge-lg badge-success" style="font-size: 20px;">{{ 'S/. ' . $this->importe_a_devolver }}</span>
                            </h5>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <x-master.select label="Banco" name="banco_id" wire:model.defer="form.banco_id" :options="$bancos" />
                            <x-master.input label="N° Cuenta Bancaria" type="text" name="form.nro_cuenta_bancaria" wire:model.defer="form.nro_cuenta_bancaria" />
                        </div>
                        <div class="form-control">
                            <label for="" class="label">
                                <span class="label-text">Observaciones</span>
                            </label>
                            <textarea class="textarea textarea-bordered" name="form.observacion" wire:model.defer="form.observacion" placeholder="Observaciones (Opcional)"></textarea>
                        </div>
                        <button class="btn btn-success btn-sm mt-3" wire:loading.attr="disabled"
                            onclick="confirm('¿Está seguro? No podrá recuperar los servicios después.')||event.stopImmediatePropagation()"
                        >
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
