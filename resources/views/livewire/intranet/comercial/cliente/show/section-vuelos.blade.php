<x-master.item class="py-4 px-2" label="Historial de pasajes" sublabel="Lista de pasajes adquiridos">
    <x-slot name="avatar"><i class="text-xl la la-list"></i></x-slot>
    <x-slot name="actions">
        <x-master.input label="Fecha"></x-master.input>
    </x-slot>
</x-master.item>
<div class="overflow-x-auto">
    <table class="table w-full mt-3 table-striped table-responsive">
        <thead>
            <tr>
                <th>COD</th>
                <th>Nombre</th>
                <th>Fecha adq.</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cliente->pasajes_adquiridos as $pasaje)
                <tr>
                    <td>{{ $pasaje->codigo }}</td>
                    <td>{{ $pasaje->nombre_short }}</td>
                    <td>
                        <small>
                            {{ optional($pasaje->created_at)->format('Y-m-d') }} <br>
                            {{ optional($pasaje->created_at)->format('g:i a') }}
                        </small>
                    </td>
                    <td>
                        <x-item.ubicacion :ubicacion="$pasaje->get_origen">
                            @if ($pasaje->vuelo_origen)
                                <x-master.item label="Horario de despegue" sublabel="{{ optional(optional($pasaje->vuelo_origen)->fecha_hora_vuelo_programado)->format('Y-m-d g:ia') }}"/>
                            @endif
                        </x-item.ubicacion>
                    </td>
                    <td>
                        <x-item.ubicacion :ubicacion="$pasaje->get_destino">
                            @if ($pasaje->vuelo_destino)
                                <x-master.item label="Horario de aterrizaje" sublabel="{{ optional(optional($pasaje->vuelo_destino)->fecha_hora_aterrizaje_programado)->format('Y-m-d g:ia') }}"/>
                            @endif
                        </x-item.ubicacion>
                    </td>
                    <td>
                        @include('livewire.intranet.comercial.pasaje.components.status')
                    </td>
                    <td>
                        <a class="btn btn-outline btn-sm btn-success" href="{{ route('intranet.comercial.pasaje.show', $pasaje) }}">
                            <i class="la la-eye"></i>
                        </a>
                        {{-- @if ($pasaje->can_export_boarding_pass)
                            <a target="_blank" href="{{ route('intranet.comercial.pasaje.export.boarding-pass', $pasaje) }}" class="btn btn-outline btn-sm btn-warning">
                                <i class="la la-file"></i>
                            </a>
                        @endif --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
