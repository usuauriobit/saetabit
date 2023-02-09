@if ($pasaje->trashed())
    <div class="badge badge-danger badge-outline">
        Anulado
    </div>
@else
    @if ($pasaje->is_abierto)
        <div class="badge badge-warning badge-outline">
            Abierto
        </div>
    @else
        <div class="badge badge-warning badge-outline">
            Asignado
        </div>
    @endif
@endif
