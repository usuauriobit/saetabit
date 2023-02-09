<div>
    <div class="cabecera p-6">
        <x-master.item labelSize="xl" label="{{ ucfirst('Penalidades') }}"
            sublabel="Lista de penalidades por cambios/fechas abiertas">
        </x-master.item>
    </div>
    <div class="grid grid-cols-3 gap-4">
        @foreach ($pasaje_cambio_tarifas as $pct)
            @if (optional($pct->categoria_vuelo)->descripcion !== 'Compañía')
                <div class="card-white">
                    <div class="p-2"
                        style="background-image: url('{{ asset('img/default/colorful10.jpg') }}'); background-position:; background-repeat: no-repeat; background-size: cover;">
                        <div class="card-white">
                            <div class="card-body">
                                <div class="flex justify-between items-center gap-4">
                                    <span
                                        class="text-h4"><strong>{{ optional($pct->categoria_vuelo)->descripcion }}</strong></span>
                                    @can('intranet.configuracion.pasaje-cambio-tarifa.edit')
                                        <a href="{{ route('intranet.configuracion.pasaje_cambio_tarifa.edit', $pct) }}"
                                            class="btn btn-primary">
                                            <i class="la la-edit"></i>
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="flex justify-between my-2 gap-4">
                            <div>Cambio de fecha</div>
                            <div class="text-primary font-bold">@soles($pct->monto_cambio_fecha)</div>
                        </div>
                        <div class="flex justify-between my-2">
                            <div>Penalidad de pasaje <br> abierto</div>
                            <div class="text-primary font-bold">@soles($pct->monto_cambio_abierto)</div>
                        </div>
                        <div class="flex justify-between my-2">
                            <div>Cambio de titularidad</div>
                            <div class="text-primary font-bold">@soles($pct->monto_cambio_titularidad)</div>
                        </div>
                        <div class="flex justify-between my-2">
                            <div>Cambio de ruta</div>
                            <div class="text-primary font-bold">@soles($pct->monto_cambio_ruta)</div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
