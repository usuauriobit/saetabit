<div>
    <div class="my-4 text-lg font-bold">
        Lista de vuelos generados ( {{ count($this->vuelos_generados_model) }} vuelos)
    </div>

    @if (count($this->vuelos_generados_model) == 0)
        <div class="py-20 text-center card-white">
            <div class="text-xl">
                <i class="text-4xl las la-stream"></i>
                <br>
                <br>
                <strong>No se generó ningún vuelo</strong>
            </div>
        </div>
    @else
        @foreach ($this->vuelos_generados_model as $vuelo)
        {{-- {{ var_dump($vuelo->nro_asientos_disponibles) }} --}}

        <div class="grid items-center grid-cols-5 gap-4 my-2">
            <div class="col-span-4">
                <x-item.vuelo-horizontal-simple
                    wire:key="vuelo{{$loop->index}}"
                    :vuelos="[$vuelo]"
                />
            </div>
            <button class="btn btn-danger" onclick="confirm('¿Está seguro de eliminar?') || event.stopImmediatePropagation()" wire:click="removeVuelo({{$loop->index}})">
                <i class="text-2xl la la-trash"></i>
            </button>
        </div>
        @endforeach
        <button wire:click="save" class="w-full btn btn-primary" onclick="confirm('¿Está seguro?') || event.stopImmediatePropagation()">
            <i class="text-lg la la-save"></i> Guardar
        </button>
    @endif

</div>
