@if (!$vuelo->user_confirmed)
    <div class="badge badge-ghost {{isset($wFull) ? 'w-full' : ''}}">Registrado</div>
@elseif(!$vuelo->hora_despegue)
    <div class="badge badge-info badge-outline {{isset($wFull) ? 'w-full' : ''}}">Confirmado</div>
@elseif(!$vuelo->hora_aterrizaje)
    <div class="badge badge-info {{isset($wFull) ? 'w-full' : ''}}">En ruta</div>
@elseif(!$vuelo->hora_aterrizaje)
    <div class="badge badge-success badge-outline {{isset($wFull) ? 'w-full' : ''}}"> Aterrizado</div>
@elseif(!$vuelo->is_confirmed)
    <div class="badge badge-success {{isset($wFull) ? 'w-full' : ''}}">Finalizado</div>
@endif


{{--

 --}}
