<div class="container mx-auto">
    <div class="mb-2 card-white mt-4">
        <div class="p-4"
            style="background-image: url('{{ asset('img/default/colorful17.jpg') }}'); background-position:; background-repeat: no-repeat; background-size: cover;">
            <div class=" card-white">
                <div class="p-4">
                    <div class="text-h3 font-bold ">Detalle</div>
                </div>
                @foreach ($orden_pasaje->pasajes as $pasajero)
                    <div class="grid items-center flex-1 grid-cols-1 gap-4 p-2 md:grid-cols-4 lg:grid-cols-4">
                        <x-master.item class="my-1" label="Pasajero" sublabel="{{ $pasajero->nombre_short }}" />
                        <x-master.item class="my-1" label="Ruta">
                            <x-slot name="sublabel">
                                {{ $pasajero->vuelo_desc }}
                            </x-slot>
                        </x-master.item>
                        <x-master.item class="my-1" label="Fecha"
                            sublabel="{{ optional($pasajero->fecha_hora_vuelo_programado)->format('Y-m-d') }}" />
                        <x-master.item class="my-1" label="Importe">
                            <x-slot name="sublabel">
                                @toSoles($pasajero->importe_final)
                            </x-slot>
                        </x-master.item>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
