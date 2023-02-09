<div class=" bordered" wire:key="pasajeResumen{{$type ?? 'libre'}}{{$pasaje->temporal_id}}">
    <div class="flex">
        <div class="flex-none p-2 font-bold text-center text-white w-14 h-14 bg-primary">
            {{$loop->iteration}}
        </div>
        <div class="grid items-center flex-1 grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-3">

            <x-master.item class="my-1" label="Pasajero">
                <x-slot name="sublabel">
                    {{$pasaje['pasajero']['nombre_short']}}
                    <div class="text-xl font-bold text-success">
                        {{optional($pasaje['pasajero'])['nro_doc']}}
                    </div>
                    <div class="badge badge-success">
                        {{optional($pasaje['pasajero']['tipo_documento'] ?? null)['descripcion'] ?? '-'}}
                    </div>
                </x-slot>
            </x-master.item>
            <x-master.item class="my-1" label="Importe">
                <x-slot name="sublabel">
                    <div class="text-xl font-bold text-primary">
                        @if ($pasaje->is_importe_variado_calc )
                            <del class="text-grey">
                                @if ($pasaje->is_dolarizado)
                                    @dolares($pasaje['importe']) <br>
                                    @toSoles($pasaje['importe'])
                                @else
                                    @soles($pasaje['importe']) <br>
                                @endif
                            </del>
                            <br>
                        @else
                            @if ($pasaje->is_dolarizado)
                                @dolares($pasaje['importe_final_calc']) <br>
                                @toSoles($pasaje['importe_final_calc'])
                            @else
                                @soles($pasaje['importe_final_calc']) <br>
                            @endif
                        @endif
                        <br>
                        <div class="badge badge-info">
                            {{$pasaje['tipo_pasaje']['abreviatura']}}
                        </div>
                    </div>
                </x-slot>
            </x-master.item>
            <div>
                @if (!$this->isLibre)
                    @if ($pasaje->descuento)
                        @include('components.item.descuento', ['descuento' => $pasaje->descuento])
                        <button class="btn btn-sm btn-outline" wire:click="quitarDescuentoPasaje('{{$pasaje['temporal_id']}}')">
                            <i class="text-xl la la-trash"></i>
                        </button>
                    @else
                        <div class="dropdown">
                            <div tabindex="1" class="m-1 btn btn-outline btn-sm">Aplicar descuento</div>
                            <ul tabindex="1" class="p-2 shadow menu dropdown-content bg-base-100 rounded-box w-80">
                                @foreach ($this->getDescuentosFromPasaje($pasaje, $this->{$type.'_vuelos_selected_model'}[0]) as $descuento)
                                    <li wire:key="{{$pasaje['temporal_id']}}{{$descuento->id}}">
                                        <button type="button" wire:click="asignarDescuentoPasaje('{{$pasaje['temporal_id']}}' , '{{$descuento->id}}')">
                                            @include('components.item.descuento')
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                @endif
            </div>
        </div>
    </div>
</div>
