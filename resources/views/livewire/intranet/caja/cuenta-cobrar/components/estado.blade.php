<div class="flex justify-center mt-3">
    @if ($row->canCreateAmortizacion())
        @if ($row->is_pagado)
            <div class="badge badge-success badge-sm">¡Cancelado!</div>
        @else
            <div class="badge badge-warning badge-sm">¡Saldo Pendiente!</div>
        @endif
    @endif
    @if ($row->disponible_facturar)
        @if ($row->comprobante)
            <div class="badge badge-success badge-sm">¡Facturado!</div>
        @else
            <div class="badge badge-warning badge-sm">¡Pendiente de Facturación!</div>
        @endif
    @endif
</div>
