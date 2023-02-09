<div class="p-4">
    <div class="grid grid-cols-4 gap-4 ">
        <div class="col-span-1">
            <div class="card-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Descripcion" :sublabel="$avion->descripcion"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Matricula" :sublabel="$avion->matricula"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Modelo" :sublabel="$avion->modelo"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Tipo motor" :sublabel="optional($avion->motor)->descripcion">
                            </x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Estado avion" :sublabel="optional($avion->estado)->descripcion">
                            </x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Fabricante" :sublabel="optional($avion->fabricante)->descripcion">
                            </x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Nro asientos" :sublabel="$avion->nro_asientos"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Nro pilotos" :sublabel="$avion->nro_pilotos"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Peso max pasajeros" :sublabel="$avion->peso_max_pasajeros">
                            </x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Peso max carga" :sublabel="$avion->peso_max_carga"></x-master.item>
                        </div>
                        <div class="col-md-12">
                            <x-master.item class="mb-4" label="Fecha fabricacion" :sublabel="optional($avion->fecha_fabricacion)->format('Y-m-d')">
                            </x-master.item>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-3">
            <div class="py-6">
                <x-master.item label="Tiempos de vuelo" sublabel="{{ $avion->matricula }}">
                    <x-slot name="actions">
                        <a href="{{ route('intranet.mantenimiento.tiempo-avion-tramo.create', $avion->id) }}" class="btn btn-primary"> <i class="la la-plus"></i>
                            Agregar
                        </a>
                    </x-slot>
                </x-master.item>
            </div>
            <div class="grid grid-cols-3 gap-4">
                @foreach ($avion->tiempo_avion_tramos->groupBy('tiempo_vuelo') as $tiempo_vuelo => $tiempo_avion_tramos)
                    <div class="card-white">
                        <div class="card-body">
                            @foreach ($tiempo_avion_tramos as $tiempo_avion_tramo)
                            <div class="grid grid-cols-3 gap-4 my-2">
                                <div>
                                    <strong>{{ optional(optional($tiempo_avion_tramo->tramo)->origen)->distrito }}</strong>
                                </div>
                                <div class="text-center">
                                    <i class="las la-arrow-right"></i>
                                </div>
                                <div class="text-right">
                                    <strong>{{ optional(optional($tiempo_avion_tramo->tramo)->destino)->distrito }}</strong>
                                    <a href="{{ route('intranet.mantenimiento.tiempo-avion-tramo.edit', $tiempo_avion_tramo) }}">
                                        <i class="la la-edit text-red-500"></i>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                            <div class="text-center font-bold text-2xl mt-4 text-primary">
                                {{ $tiempo_vuelo }} min
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
