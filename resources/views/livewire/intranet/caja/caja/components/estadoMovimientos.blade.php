@if ($row->trashed())
    <div class="badge badge-error">Extornado</div>
@else
    @if ($row->solicitud_extorno_by != null)
        <div class="badge badge-warning">Solicitud de Extorno</div>
    @else
        <div class="badge badge-success">Pagado</div> <br>
        @isset ($row->documentable->comprobante->ultima_respuesta)
            @if (optional($row->documentable->comprobante->ultima_respuesta ?? null)->enlace_del_pdf != null)
                <div class="badge badge-success">Facturado</div>
            @else
                <div class="badge badge-error">¡Error!</div>
            @endif
        @else
            <div class="badge badge-warning">Sin Facturar</div>
        @endisset
    @endif
@endif
