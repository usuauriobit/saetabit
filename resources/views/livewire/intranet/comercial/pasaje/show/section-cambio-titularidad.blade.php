<div>
    <div class="mt-4 shadow-lg alert alert-info">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="flex-shrink-0 w-6 h-6 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Fecha límite para permitir Cambio de titular:
                <strong>{{ optional($pasaje->cambio_titularidad_limit)->format('Y-m-d g:i a') }}</strong>
            </span>
        </div>
    </div>
    <div class="cabecera p-6">
        <x-master.item label="Cambio de titular" sublabel="Historial de cambios de titularidad">
            <x-slot name="actions">
                @can('intranet.comercial.pasaje.cambio.titular.create')
                    @if (!$pasaje->is_expired)
                        <a href="#createPasajeCambioModal" class="btn btn-primary"> <i class="la la-plus"></i>
                            Registrar
                        </a>
                    @endif
                @endcan
            </x-slot>
        </x-master.item>
    </div>

    @if ($pasaje->cambios_titularidad->count() > 0)
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pasajero anterior</th>
                        <th>Pasajero sustituyente</th>
                        <th>Importe</th>
                        <th>Nota</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        {{-- <th></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pasaje->cambios_titularidad as $cambio)
                        <tr>
                            <td>{{ $cambio->id }}</td>
                            <td>{{ optional($cambio->pasajero_anterior)->nombre_short }}</td>
                            <td>{{ optional($cambio->pasajero_nuevo)->nombre_short }}</td>
                            <td>@soles($cambio->importe_penalidad)</td>
                            <td>{{ $cambio->nota }}</td>
                            <td>{{ $cambio->created_at->format('Y-m-d g:i a') }}</td>
                            <td>
                                @include('livewire.intranet.comercial.pasaje-cambio.components.badge-status',
                                    ['cambio' => $cambio])
                            </td>
                            {{-- <td>
                                @if ($cambio->can_eliminar)
                                    <button class="btn btn-error btn-outline btn-sm"
                                        onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()"
                                        wire:loading.attr="disabled"
                                        wire:click="eliminarCambio">
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
                <span>Este pasaje no tiene cambios de titularidad</span>
            </div>
        </div>
    @endif

    <x-master.modal id-modal="createPasajeCambioModal" w-size="xl" label="Registrar Cambio de titular">
        <livewire:intranet.comercial.pasaje-cambio.create.cambio-titularidad :pasaje_id="$pasaje->id" />
    </x-master.modal>

</div>
