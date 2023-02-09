<div class=" bordered" wire:key="pasajeItem{{$type ?? 'libre'}}{{$pasaje['temporal_id']}}">
    <div class="flex">
        <div class="flex-none p-2 font-bold text-center text-white w-14 h-14 bg-primary">
            {{$loop->iteration}}
        </div>
        <div class="grid items-center flex-1 grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-3">

            <x-master.item class="my-1" label="Pasajero">
                <x-slot name="sublabel">
                    <div>
                        <div class="text-gray-400">Nombre: </div>
                        <div class="font-bold">
                            {{$pasaje['pasajero']['nombre_short']}}
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="text-gray-400">Documento: </div>
                        <div class="text-xl font-bold text-success">
                            {{optional($pasaje['pasajero'])['nro_doc']}}
                        </div>
                        <div class="badge badge-success">
                            {{optional($pasaje['pasajero']['tipo_documento'] ?? null)['descripcion'] ?? '-'}}
                        </div>
                    </div>
                </x-slot>
            </x-master.item>
            <x-master.item class="my-1" label="Datos básicos">
                <x-slot name="sublabel">
                    <div>
                        <div class="text-gray-400">Sexo: </div>
                        <div class="badge badge-info">{{$pasaje['pasajero']['sexo_desc']}}</div>
                    </div>
                    <div class="mt-2">
                        <div>
                            <div class="text-gray-400">Fecha de nacimiento: </div>
                            {{ optional(optional($pasaje->pasajero)->fecha_nacimiento)->format('Y-m-d')}}
                            ({{optional($pasaje->pasajero)->edad}} años)
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="text-gray-400">Peso estimado: </div>
                        {{$pasaje->peso_persona}} Kg
                    </div>
                </x-slot>
            </x-master.item>
            <x-master.item class="my-1" label="Datos de contacto">
                <x-slot name="sublabel">
                    <div>
                        <div class="text-gray-400">Teléfono: </div>
                        {{$pasaje->telefono ?? '-'}}
                    </div>
                    <div>
                        <div class="text-gray-400">Email: </div>
                        {{$pasaje->email ?? '-'}}
                    </div>
                    <div>
                        <div class="text-gray-400">Descripción: </div>
                        {{$pasaje->descripcion ?? '-'}}
                    </div>
                </x-slot>
            </x-master.item>
        </div>
        <div class="flex-none p-2 font-bold text-center">
            <button class="btn btn-error btn-sm btn-outline" onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()" wire:click="deletePasaje('{{$pasaje['temporal_id']}}')">
                <i class="text-lg la la-trash"></i>
            </button>
        </div>
    </div>
</div>
