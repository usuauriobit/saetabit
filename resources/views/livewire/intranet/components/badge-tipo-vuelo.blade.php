@php
    switch ($tipo_vuelo['descripcion']) {
        case 'No regular':
            $color = 'red';
            break;
        case 'Comercial':
            $color = 'blue';
            break;
        case 'Subvencionado':
            $color = 'green';
            break;
        case 'Convenio':
            $color = 'purple';
            break;
        case 'Chárter Comercial':
            $color = 'yellow';
            break;
        case 'Emergencia médica':
            $color = 'blue';
            break;
        case 'Carga':
            $color = 'yellow';
            break;
        case 'Compañía':
            $color = 'gray';
            break;
        default:
            $color = 'gray';
            break;
    }
@endphp

<div class="rounded-lg px-2 w-auto bg-{{ $color }}-100 text-{{ $color }}-800">
    @if (!$tipo_vuelo->is_desc_same_as_category)
        <span class="text-sm font-bold">
            {{ optional(optional($tipo_vuelo)->categoria_vuelo)->descripcion }}
        </span>
        <br>
    @endif
    {{ optional($tipo_vuelo)->descripcion }}
</div>
