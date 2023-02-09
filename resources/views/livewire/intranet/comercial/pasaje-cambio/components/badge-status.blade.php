@if ($cambio->trashed())
    <div class="badge badge-outline badge-error">Denegado</div>
@elseif ($cambio->is_confirmado)
    <div class="badge badge-outline badge-success">Confirmado</div>
@elseif (!$cambio->is_confirmado)
    <div class="badge badge-outline badge-warning">Sin confirmar</div>
@endif
