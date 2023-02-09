<div id="pasajeroActionOptions{{ $pasaje->id }}">
    <div class="dropdown dropdown-end">
        <label tabindex="0" class="m-1 btn btn-sm btn-primary btn-outline">Opciones</label>
        <ul tabindex="0" style="margin-left: -100px"
            class="p-1 shadow menu dropdown-content bg-base-100 rounded-box w-60">
            <li>
                <a href="{{ route('intranet.comercial.pasaje.show', $pasaje->id) }}">
                    <i class="mr-1 las la-eye text-info"></i> Ver pasaje
                </a>
            </li>
            <li>
                <a target="_blank" href="{{ route('intranet.comercial.pasaje.export.documento-informativo', $pasaje) }}">
                    <i class="mr-1 la la-file text-warning"></i> Ficha informativa
                </a>
            </li>
            @if (!optional($vuelo ?? null)->is_closed)

                @if (isset($vuelo) && !$vuelo->is_closed && !$pasaje->is_abierto)
                    <li>
                        <a href="#addBultoModal{{ $pasaje->id }}">
                            <i class="mr-1 las la-suitcase-rolling text-info"></i> Registrar equipaje/mascota
                        </a>
                    </li>
                @endif
                <li>
                    @if ($pasaje->is_asiento_libre)
                        <a href="#" wire:click="quitarLiberarAsiento">
                            <i class="mr-1 la la-close text-danger"></i> Volver a ocupar asiento
                        </a>
                    @else
                        <a href="#" wire:click="liberarAsiento">
                            <i class="mr-1 la la-close text-danger"></i> Liberar asiento
                        </a>
                    @endif
                </li>

                @if ($pasaje->has_checkin)
                    <li>
                        <a href="#" wire:click="deleteCheckin">
                            <i class="mr-1 la la-close text-danger"></i> Quitar Check-in
                        </a>
                    </li>
                @else
                    @if ($pasaje->canLiberar)
                        <li>
                            <a href="{{route('intranet.comercial.pasaje.show', $pasaje)}}">
                                <div>
                                    <i class="mr-1 las la-sign-out-alt text-info"></i> Asign. como fecha abierta
                                    (Ver perfil)
                                    {{-- <br>
                                    <div class="badge badge-primary">
                                        @soles($pasaje->monto_cambio_abierto)
                                    </div> --}}
                                </div>
                            </a>
                        </li>
                    @endif
                    @if ($pasaje->can_export_boarding_pass)
                        <li>
                            <a target="_blank" href="{{ route('intranet.comercial.pasaje.export.boarding-pass', $pasaje) }}">
                                <i class="mr-1 la la-file text-warning"></i> Generar boarding-pass
                            </a>
                        </li>
                    @endif
                    @if ($pasaje->can_anular)
                        <li>
                            <a href="#modalAnularPasaje{{ $pasaje->id }}">
                                <i class="mr-1 la la-trash text-danger"></i> Anular pasaje
                            </a>
                        </li>
                    @endif
                @endif
            @endif
        </ul>
    </div>
    @if (isset($vuelo) && !$vuelo->is_closed && !$pasaje->is_abierto)
        <x-master.modal id-modal="addBultoModal{{ $pasaje->id }}" label="Registrar equipaje/mascota">
            <livewire:intranet.programacion-vuelo.vuelo.show.section-pasajeros.form-add-bulto :pasaje="$pasaje" />
        </x-master.modal>
    @endif
</div>
