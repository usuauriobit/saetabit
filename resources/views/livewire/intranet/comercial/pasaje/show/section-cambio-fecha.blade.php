<div>
    <div class="mt-4 shadow-lg alert alert-info">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="flex-shrink-0 w-6 h-6 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Fecha límite para permitir cambio de fecha:
                <strong>{{ optional($pasaje->cambio_fecha_limit)->format('Y-m-d g:i a') }}</strong>
            </span>
        </div>
    </div>
    <div class="cabecera p-6">
        <x-master.item label="Cambio de fecha" sublabel="Historial de cambios de fecha">
            <x-slot name="actions">
                @can('intranet.comercial.pasaje.cambio.fecha.create')
                    @if (!$pasaje->is_expired)
                        <a href="#createPasajeCambioFechaModal" class="btn btn-primary"> <i class="la la-plus"></i>
                            Registrar
                        </a>
                    @endif
                @endcan
            </x-slot>
        </x-master.item>
    </div>

    @if ($pasaje->cambios_fecha->count() > 0)
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>COD vuelo ant.</th>
                        <th>COD vuelo sust.</th>
                        <th>Fecha ant.</th>
                        <th>Fecha sust.</th>
                        <th>Importe</th>
                        <th>Nota</th>
                        <th>Estado</th>
                        {{-- <th></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pasaje->cambios_fecha as $cambio)
                        <tr>
                            <td>{{ $cambio->id }}</td>
                            <td>{{ optional(optional($cambio->cambio_vuelo_origen_anterior)->vuelo)->codigo }}</td>
                            <td>{{ optional(optional($cambio->cambio_vuelo_origen_posterior)->vuelo)->codigo }}</td>
                            <td>{{ optional(optional($cambio->cambio_vuelo_origen_anterior->vuelo)->fecha_hora_vuelo_programado)->format('Y-m-d') }}
                            </td>
                            <td>{{ optional(optional($cambio->cambio_vuelo_origen_posterior->vuelo)->fecha_hora_vuelo_programado)->format('Y-m-d') }}
                            </td>
                            <td>
                                {{-- @dolares($cambio->importe_total) <br> --}}
                                @soles($cambio->importe_total)
                            </td>
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
                <span>Este pasaje no tiene cambios de fecha</span>
            </div>
        </div>
    @endif

    <x-master.modal id-modal="createPasajeCambioFechaModal" w-size="2xl" label="Registrar cambio de fecha">
        <livewire:intranet.comercial.pasaje-cambio.create.cambio-fecha :pasaje_id="$pasaje->id" />
    </x-master.modal>

</div>
