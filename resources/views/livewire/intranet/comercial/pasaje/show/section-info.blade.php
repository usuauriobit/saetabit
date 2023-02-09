<div class="card-white">
    @if (!$pasaje->is_abierto)
        <x-item.vuelo-horizontal-simple
            wire:key="vueloitem"
            :vuelos="$pasaje->vuelos"
            transparent
            hideAsientosDisponibles
        />
    @else
        <div class="card-white">
            <div class="card-body">
                <h1>
                    <div class="badge badge-warning p-4">
                        <strong>Pasaje con fecha abierta</strong>
                    </div>
                </h2>
            </div>
        </div>
    @endif
</div>
<div class="mb-2 card-white" >
    <div class="p-4"
    style="background-image: url('{{ asset('img/default/colorful17.jpg') }}'); background-position:; background-repeat: no-repeat; background-size: cover;"
    >
    <div class=" card-white">
        <div class="grid items-center flex-1 grid-cols-1 gap-4 card-body md:grid-cols-3 lg:grid-cols-3">
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
    </div>
    </div>
</div>
