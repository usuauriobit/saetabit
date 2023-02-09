<div class=" bordered"
>
    <div class="flex">
        <div class="flex-none p-2 font-bold text-center text-white w-14 h-14 bg-primary">
            {{$nro}}
        </div>
        <div class="grid items-center flex-1 grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-3">

            @if (isset($pasaje) && isset($pasaje['pasajero']))
            <x-master.item class="my-1" label="Pasajero">
                <x-slot name="sublabel">
                    {{optional($pasaje['pasajero'] ?? null)['nombre_short']}}
                    <div class="text-xl font-bold text-success">
                        {{optional($pasaje['pasajero'] ?? null)['nro_doc']}}
                    </div>
                    <div class="badge badge-success">
                        {{optional(optional($pasaje['pasajero'] ?? null)['tipo_documento'] ?? null)['descripcion'] ?? '-'}}
                    </div>
                </x-slot>
            </x-master.item>
            <x-master.item class="my-1" label="Importe">
                <x-slot name="sublabel">
                    <div>
                        {{-- {{$pasaje->is_dolarizado ? 'Si lo es' : 'No lo es'}} --}}
                        @if ($pasaje->is_importe_variado_calc )
                            @if ($pasaje->is_dolarizado)
                                <del class="text-gray-400">
                                    @dolares($pasaje['importe'])
                                    <div class="text-sm">
                                        ≈ @toSoles($pasaje['importe'])
                                    </div>
                                </del>
                            @else
                                @soles($pasaje['importe'])
                            @endif
                        @endif
                        <div class="text-primary">
                            @if ($pasaje->is_dolarizado)
                                @dolares($pasaje['importe_final_calc'])
                            @else
                                @soles($pasaje['importe_final_calc'])
                            @endif
                        </div>
                        @if ($pasaje->is_dolarizado)
                            <div class="text-xl font-bold text-primary">
                                ≈ @toSoles($pasaje['importe_final_calc'])
                            </div>
                        @endif
                        <div class="badge badge-info">
                            {{optional($pasaje['tipo_pasaje'] ?? null)['abreviatura']}}
                        </div>
                    </div>
                </x-slot>
            </x-master.item>
            <div>
                @if (!$this->isLibre)
                    @if ($pasaje->descuento)
                        @include('components.item.descuento', ['descuento' => $pasaje->descuento])
                        <button class="btn btn-sm btn-outline" wire:click="quitarDescuentoPasaje('{{$pasaje->temporal_id}}')">
                            <i class="text-xl la la-trash"></i>
                        </button>
                    @else
                        @if (count($this->descuentos_pasaje) > 0)
                            <div class="dropdown">
                                <div tabindex="1" class="m-1 btn btn-outline btn-sm">Aplicar descuento</div>
                                <ul tabindex="1" class="p-2 shadow menu dropdown-content bg-base-100 rounded-box w-80">
                                    @foreach ($this->descuentos_pasaje as $descuento)
                                        <li wire:key="{{$pasaje['temporal_id']}}{{$descuento->id}}">
                                            <a href="#" wire:click="setDescuento('{{$pasaje['temporal_id']}}' , '{{$descuento->id}}')">
                                                @include('components.item.descuento')
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
