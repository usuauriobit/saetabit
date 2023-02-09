<div>
    <x-master.item label="Pasajeros" sublabel="Lista de pasajeros del vuelo">
        <x-slot name="avatar">
            <i class="las la-users"></i>
        </x-slot>
        <x-slot name="actions">
            <a
                href="{{ route('intranet.comercial.adquisicion-pasaje.create',
                    [
                        'alreadySetType' => 'vuelo-ruta',
                        'alreadySetId' => $vuelo_ruta->id
                    ]) }}"
                class="btn btn-primary">
                Registrar pasajero
            </a>
            {{-- @if (!$vuelo->is_closed)
            @endif --}}
        </x-slot>
    </x-master.item>
    {{-- <x-master.modal id-modal="registrarPasajeroModal" w-size="2xl">
        <h4 class="text-lg font-semibold">Registro de pasaje</h4>
        <livewire:intranet.comercial.vuelo.components.form-pasajero ></livewire:intranet.comercial.vuelo.components.form-pasajero>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
        </div>
    </x-master.modal> --}}

    <div class="overflow-x-auto">
        <table class="table w-full mt-3 table-striped table-responsive">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vuelo_ruta->pasajes as $pasaje)
                    <tr>
                        <td>{{ $pasaje->nombre_short }}</td>
                        <td>{{ optional($pasaje->tipo_pasaje)->abreviatura }}</td>
                        <td>
                            {{-- @include('livewire.intranet.comercial.vuelo.components.status-pasajero') --}}
                        </td>
                        <td>
                            <a class="btn btn-outline btn-sm btn-success" href="{{ route('intranet.comercial.pasaje.show', $pasaje) }}">
                                <i class="la la-eye"></i>
                            </a>
                            @if ($pasaje->can_export_boarding_pass)
                                <a target="_blank" href="{{ route('intranet.comercial.pasaje.export.boarding-pass', $pasaje) }}" class="btn btn-outline btn-sm btn-warning">
                                    <i class="la la-file"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
