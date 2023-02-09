@if (!$row->trashed())
    <form action="{{ route('intranet.caja.venta.show', $row->documentable_id) }}" method="get">
        @if($caja->getAperturaPendienteAttribute($current_date) != null)
            <input type="text" name="caja_apertura_id" value="{{ $caja->getAperturaPendienteAttribute($current_date)->id }}" hidden>
        @else
            <input type="text" name="caja_apertura_id" value="{{ $row->documentable->caja_movimiento[0]->apertura_cierre_id }}" hidden>
        @endif
        <input type="text" name="caja_id" value="{{ $caja->id }}" hidden>
        <button class="btn btn-circle btn-sm btn-success">
            <i class="la la-eye"></i>
        </button>
        @if ($caja->getAperturaPendienteAttribute($current_date) != null)
            @if (!$row->documentable->comprobante & $row->solicitud_extorno_by == null & $row->documentable->saldo_por_ingresar == 0 )
                @can('intranet.caja.extorno.create')
                    <a href="#solicitarExtornoModal" wire:click="createExtorno({{ $row->id }})" class="btn btn-circle btn-sm btn-error">
                        <i class="la la-trash"></i>
                    </a>
                @endcan
            @endif
        @endif
        @isset ($row->documentable->comprobante->ultima_respuesta)
            <a href="{{ optional($row->documentable->comprobante->ultima_respuesta ?? null)->enlace_del_pdf }}"
                class="btn btn-primary btn-circle btn-sm" target="_blank">
                <i class="la la-file"></i>
            </a>
        @endisset
    </form>
@endif
