<div>
    <div class="mt-4 shadow-lg alert alert-info">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="flex-shrink-0 w-6 h-6 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Fecha límite para permitir cambio de ruta:
                <strong>{{ optional($pasaje->fecha_limite_cambio)->format('Y-m-d') }}</strong>
            </span>
        </div>
    </div>
    <div class="cabecera p-6">
        <x-master.item label="Cambio de ruta" sublabel="Historial de cambios de ruta">
            <x-slot name="actions">
                @can('intranet.comercial.pasaje.cambio.ruta.create')
                    @if (!$pasaje->is_expired)
                        <a href="#createPasajeCambioRutaModal" class="btn btn-primary"> <i class="la la-plus"></i>
                            Registrar
                        </a>
                        <x-master.modal id-modal="createPasajeCambioRutaModal" w-size="2xl"
                            label="Registrar cambio de ruta">
                            <livewire:intranet.comercial.pasaje-cambio.create.cambio-ruta :pasaje="$pasaje" />
                        </x-master.modal>
                    @endif
                @endcan
            </x-slot>
        </x-master.item>
    </div>

    @if ($pasaje->cambios_ruta->count() > 0)
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>COD vuelo ant.</th>
                        <th>COD vuelo sust.</th>
                        <th>Ruta ant.</th>
                        <th>Ruta sust.</th>
                        <th>Importe</th>
                        <th>Nota</th>
                        <th>Estado</th>
                        {{-- <th></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pasaje->cambios_ruta as $cambio)
                        <tr>
                            <td>{{ $cambio->id }}</td>
                            <td>{{ optional(optional($cambio->cambio_vuelo_origen_anterior)->vuelo)->codigo }}</td>
                            <td>{{ optional(optional($cambio->cambio_vuelo_origen_posterior)->vuelo)->codigo }}</td>
                            <td>{{ optional(optional($cambio->cambio_vuelo_origen_anterior->vuelo)->fecha_hora_vuelo_programado)->format('Y-m-d') }}
                            </td>
                            <td>{{ optional(optional($cambio->cambio_vuelo_origen_posterior->vuelo)->fecha_hora_vuelo_programado)->format('Y-m-d') }}
                            </td>
                            <td>@soles($cambio->importe_penalidad)</td>
                            <td>{{ $cambio->nota }}</td>
                            <td>
                                @include('livewire.intranet.comercial.pasaje-cambio.components.badge-status',
                                    ['cambio' => $cambio])

                            </td>
                            {{-- <td>
                                @if ($cambio->can_eliminar)
                                    <button class="btn btn-error btn-sm btn-outline"
                                        onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()"
                                        wire:loading.attr="disabled"
                                        wire:click="eliminar">
                                        <i class="text-xl la la-trash"></i>
                                    </button>
                                @endif
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="shadow-lg alert">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="flex-shrink-0 w-6 h-6 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Este pasaje no tiene cambios de ruta</span>
            </div>
        </div>
    @endif
</div>
