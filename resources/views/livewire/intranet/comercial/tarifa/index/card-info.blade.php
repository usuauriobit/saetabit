<div class="card-white">
    <div class="p-2"
        style="background-image: url('{{ asset('img/default/colorful17.jpg') }}'); background-position:; background-repeat: no-repeat; background-size: cover;">
        <div class="grid grid-cols-{{ $ruta->has_escala ? '3' : '2' }} gap-4 p-2"
            style="background: rgba( 255, 255, 255, 0.67 );
                box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
                backdrop-filter: blur( 9px );
                -webkit-backdrop-filter: blur( 9px );
                border-radius: 10px;
                border: 1px solid rgba( 255, 255, 255, 0.18 );">
            <div>
                <div class="mb-2 text-lg font-bold text- ">
                    Desde
                </div>
                <div class="text-xl font-bold text-gray-400">
                    {{ optional(optional($ruta->tramo)->origen)->codigo_default }}
                </div>
                <div class="font-bold text-primary">
                    {{ optional(optional(optional($ruta->tramo)->origen)->ubigeo)->distrito }}
                </div>
            </div>
            @if ($ruta->has_escala)
                <div class="text-center">
                    <div class="mb-2 text-lg font-bold text- ">
                        Escala
                    </div>
                    <div class="text-xl font-bold text-gray-400">
                        {{ optional(optional($ruta->tramo)->escala)->codigo_default }}
                    </div>
                    <div class="font-bold text-primary">
                        {{ optional(optional(optional($ruta->tramo)->escala)->ubigeo)->distrito }}
                    </div>
                </div>
            @endif
            <div class="text-right">
                <div class="mb-2 text-lg font-bold text- ">
                    Hasta
                </div>
                <div class="text-xl font-bold text-gray-400">
                    {{ optional(optional($ruta->tramo)->destino)->codigo_default }}
                </div>
                <div class="font-bold text-primary">
                    {{ optional(optional(optional($ruta->tramo)->destino)->ubigeo)->distrito }}
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @can('intranet.comercial.tarifa.create')
            <button wire:key="add{{ $ruta->id }}" wire:click="setTarifaCreate({{ $ruta->id }})"
                class="mb-4 btn btn-outline btn-sm btn-primary">
                <i class="text-xl la la-plus"></i> Agregar
            </button>
        @endcan
        @foreach ($ruta->tarifas as $tarifa)
            <div class="flex justify-between my-2">
                <div>
                    <div class="text-lg font-bold">{{ $tarifa->descripcion }}</div>
                    <div class="text-secondary">{{ $tarifa->tipo_pasaje->abreviatura }}</div>
                </div>
                <div>
                    <div class="">
                        @if ($tarifa->is_dolarizado)
                            <div class="font-bold text-primary">
                                @dolares($tarifa->precio)
                            </div>
                            ≈ @toSoles($tarifa->precio)
                        @else
                            <div class="font-bold text-primary">
                                @soles($tarifa->precio)
                            </div>
                        @endif
                    </div>
                    <div>
                        @can('intranet.comercial.tarifa.edit')
                            <button wire:click="setTarifaEdit({{ $tarifa->id }})" class="ml-2 btn btn-outline btn-xs">
                                <i class="text-lg la la-edit"></i>
                            </button>
                        @endcan
                        @can('intranet.comercial.tarifa.delete')
                            <button wire:click="destroy({{ $tarifa->id }})"
                                onclick="confirm('¿Está seguro de eliminar? También se eliminará la tarifa con ruta inversa')||event.stopImmediatePropagation()"
                                class="ml-2 btn btn-error btn-outline btn-xs">
                                <i class="text-lg la la-trash"></i>
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
