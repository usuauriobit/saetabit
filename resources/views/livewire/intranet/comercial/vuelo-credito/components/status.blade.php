@if ($vuelo_credito->is_pagado)
    <div class="badge badge-success">Pagado</div>
@else
    <div class="badge badge-warning">Pendiente</div>
@endif
