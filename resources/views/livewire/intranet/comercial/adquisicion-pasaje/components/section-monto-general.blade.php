<div class="card-white">
    <div class="card-body">
        <div class="grid items-center justify-between grid-cols-2 mt-2">
            <div class="text-xl">
                <strong>Monto en pasajes</strong>
                {{-- {{$this->is_dolarizado ? 'Si lo es' : 'No lo es'}}
                {{var_dump($this->all_pasajes_plane[0]->is_dolarizado)}} --}}
            </div>
            <div class="text-2xl font-bold text-right text-primary">
                @if ($this->has_pasajes_descuento)
                    <del class="text-gray-400">
                        @if ($this->is_dolarizado)
                            @dolares($this->pasaje_importe_sin_descuento) <br>
                            ≈ <small>@toSoles($this->pasaje_importe_sin_descuento)</small>
                        @else
                            @soles($this->pasaje_importe_sin_descuento) <br>
                        @endif
                    </del>
                @endif
                <div>
                    @if ($this->is_dolarizado)
                        @dolares($this->pasaje_importe_final)
                        <div class="font-light">
                            ≈ @toSoles($this->pasaje_importe_final)
                        </div>
                    @else
                        @soles($this->pasaje_importe_final)
                    @endif
                </div>
            </div>
        </div>

        @if ($descuento_general)
            <div class="mt-8 text-sm font-bold text-gray-400">
                Importe final con descuento general
            </div>
            <div class="grid items-center justify-between grid-cols-2 mt-2">
                <div class="text-md">
                    @include('components.item.descuento', ['descuento' => $descuento_general])
                    <button class="btn btn-sm btn-outline" wire:click="quitarDescuentoGeneral()">
                        <i class="text-xl la la-trash"></i>
                    </button>
                </div>
                <div class="text-2xl font-bold text-right text-primary">
                    @if ($this->is_dolarizado)
                        @dolares($this->monto_final)
                        <br>
                        ≈ @toSoles($this->monto_final)
                    @else
                        @soles($this->monto_final)
                    @endif
                </div>
            </div>
        @else
            {{-- @if ($this->can_have_descuento_general)
                <div class="dropdown">
                    <div tabindex="1" class="m-1 btn btn-outline btn-sm">Aplicar descuento</div>
                    <ul tabindex="1" class="p-2 shadow menu dropdown-content bg-base-100 rounded-box w-80">
                        @foreach ($this->descuentos_vuelo as $descuento)
                            <li wire:key="descuentoGeneral{{ $descuento->id }}">
                                <a href="#" wire:click="asignarDescuentoGeneral({{ $descuento->id }})">
                                    @include('components.item.descuento')
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="alert alert-warning">
                    <div class="flex-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="w-6 h-6 mx-2 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        <label>No hay descuentos aplicables</label>
                    </div>
                </div>
            @endif --}}
        @endif

        @if ($this->monto_descuento_total)
            <div class="mt-8">
                <div class="mt-8 text-sm font-bold text-gray-400">
                    Monto ahorrado en detalle general: <br>
                    <strong>
                        @if ($this->is_dolarizado)
                            @dolares($this->monto_descuento_total)
                            <br>
                            ≈ @toSoles($this->monto_descuento_total)
                        @else
                            @soles($this->monto_descuento_total)
                        @endif
                    </strong>
                </div>
            </div>
        @endif
    </div>
</div>

@if ($this->have_to_approve)
    <div class="card-white mt-2">
        <div class="card-body">
            @if ($aproved_by)
                <x-master.item class="my-3" label="Aprobado por:" sublabel="{{optional($aproved_by)->user_name}}"></x-master.item>
            @else
                <a class="btn btn-info w-full"  href="#modalApproveFree">Aprobar adquisición</a>
                <small>
                    Se requiere la contraseña de un usuario con los permisos para autorizar esta acción.
                </small>
                <livewire:intranet.components.modal-password-validation modalName="modalApproveFree" eventName="approvedFree" permission="intranet.comercial.pasaje.create-free" />
            @endif
        </div>
    </div>
@endif

