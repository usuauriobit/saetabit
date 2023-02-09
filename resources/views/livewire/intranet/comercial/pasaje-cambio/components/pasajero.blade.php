<div class="text-grey-500">
    {{ optional($row->pasajero_nuevo)->nombre_short }}
    @if ($row->tipo_pasaje_cambio->descripcion == 'Cambio de titular')
        <div class="badge badge-outline badge-success"><strong>Nuevo</strong></div>
    @endif
</div>
@if ($row->tipo_pasaje_cambio->descripcion == 'Cambio de titular')
    <div class="text-grey-500">
        {{ optional($row->pasajero_anterior)->nombre_short }}
        <div class="badge badge-outline badge-warning"><strong>Anterior</strong></div>
    </div>
@endif
