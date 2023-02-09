<div>
    @section('title', __('Devoluciones'))
    <div class="cabecera p-6">
        <x-master.item label="{{ ucfirst('Devolución N°' . $devolucion->codigo) }}" sublabel="Devoluciones">
            <x-slot name="actions">
                @if ($devolucion->status_reviewed == 'En Evaluación')
                    @can('intranet.caja.devolucion.reviewed')
                        <button wire:click="approve()" class="btn btn-sm btn-success"
                            onclick="confirm('¿Está seguro de aprobar la devolución?')||event.stopImmediatePropagation()">
                            Aprobar <i class="la la-check"></i>
                        </button>
                        <button wire:click="toRefuse()" class="btn btn-sm btn-error"
                            onclick="confirm('¿Está seguro de rechazar la devolución?')||event.stopImmediatePropagation()">
                            Rechazar <i class="la la-close"></i>
                        </button>
                    @endcan
                @endif
                <a class="btn btn-primary btn-sm" href="{{ route('intranet.caja.devolucion.index') }}">
                    Volver
                </a>
            </x-slot>
        </x-master.item>
        @if ($devolucion->status_reviewed == 'En Evaluación')
            <div class="alert alert-warning shadow-lg">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <span>Aviso: La devolución se encuentra <span style="font-weight: bold">{{ $devolucion->status_reviewed }}</span> por tesorería.</span>
                </div>
            </div>
        @endif
        <div class="grid grid-cols-4 gap-4 mt-2">
            <div class="card-white">
                <div class="card-body">
                    <button class="btn gap-2 badge-{{$devolucion->color_status}} mt-2">
                        <div class="badge badge-secondary">Estado:</div>
                        {{ $devolucion->status_reviewed }}
                    </button>
                    <h3 class="card-title mt-2 ml-4">Datos del Servicio</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <x-master.item label="Venta N°" sublabel="{{ $devolucion->placelable->venta->codigo }}"/>
                        <x-master.item label="Comprobante N°" sublabel="{{ $devolucion->placelable->venta->correlativo_completo }}"/>
                    </div>
                    <x-master.item class="mt-2" label="N° Doc" sublabel="{{ optional($devolucion->placelable->venta ?? null)->nro_documento ?? '-' }}"/>
                    <x-master.item class="mt-2" label="Cliente" sublabel="{{ optional($devolucion->placelable->venta->clientable ?? null)->nombre_completo ?? '-' }}"/>
                    <x-master.item class="mt-2" label="Descripción" sublabel="{{ $devolucion->placelable->descripcion ?? '-' }}"/>
                    <div class="grid grid-cols-2 gap-4">
                        <x-master.item class="mt-2" label="Tipo Servicio" sublabel="{{ $devolucion->placelable->tipo_servicio ?? '-' }}"/>
                        <x-master.item class="mt-2" label="Fecha" sublabel="{{ $devolucion->placelable->venta->created_at->format('Y-m-d') }} "/>
                    </div>
                    <x-master.item class="mt-2" label="Importe" sublabel="{{ 'S/. ' . number_format($devolucion->placelable->importe, 2, '.', ',') }} "/>
                </div>
            </div>
            <div class="card-white col-span-3">
                <div class="card-body">
                    <h3 class="card-title mt-2 ml-4">Datos de la Devolución</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <x-master.item class="mt-2" label="Motivo" sublabel="{{ $devolucion->devolucion_motivo->descripcion ?? '-' }}"/>
                        </div>
                        <x-master.item class="mt-2" label="Fecha" sublabel="{{ $devolucion->fecha->format('Y-m-d') ?? '-' }}"/>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <x-master.item class="mt-5" label="Importe" sublabel="{{ 'S/. ' . number_format($devolucion->importe, 2, '.', ',') }}"/>
                        <x-master.item class="mt-5" label="Gastos Administrativos" sublabel="{{ 'S/. ' . number_format($devolucion->gasto_administrativos, 2, '.', ',') }}"/>
                        <h5 class="text-xl text-center mt-5">
                            Importe a Devolver <br>
                            <span class="badge badge-lg badge-success" style="font-size: 20px;">
                                @soles($devolucion->importe_devolucion)
                            </span>
                        </h5>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <x-master.item class="mt-5" label="Banco" :sublabel="$devolucion->banco->descripcion"/>
                        <x-master.item class="mt-5" label="N° Cuenta Bancaria" :sublabel="$devolucion->nro_cuenta_bancaria"/>
                    </div>
                    <x-master.item class="mt-2" label="Observaciones" sublabel="{{ $devolucion->observacion ?? '-' }}"/>
                </div>
            </div>
            @if ($devolucion->status_reviewed !== 'En Evaluación')
                <div class="card-white">
                    <div class="card-body">
                        <h3 class="card-title mt-2 ml-4">Revisión</h3>
                        <x-master.item class="mt-2" :label="$devolucion->status_reviewed . ' por: '" :sublabel="$devolucion->reviewed_by->name ?? null"/>
                        <x-master.item class="mt-2" label="Fecha" :sublabel="optional($devolucion->date_reviewed)->format('d-m-Y')"/>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

