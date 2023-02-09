<div x-data="{
    handleOnChange(e) {
        if(e.target.type !== 'number' ||e.target.type !== 'date'  || e.target.type !== 'datetime'   ){
            e.target.value = this.quitarAcentos(e.target.value.toUpperCase())
        }
    },
    quitarAcentos(str) {
        const acentos = {'Á':'A','É':'E','Í':'I','Ó':'O','Ú':'U'};
        return str.split('').map( letra => acentos[letra] || letra).join('').toString();
    }
}">
    <div class="w-full dropdown" >
        <div tabindex="0" class="w-full">
            <label class="block mb-2 text-sm font-bold text-gray-700" for="username">
                Buscar avión
            </label>
            <input wire:model.debounce.600ms="search_avion"
                x-on:keyup="handleOnChange"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                type="text"
                placeholder="Escribe la descripción o matrícula del avión" >
          {{-- <x-master.input class="w-full" label="Buscar" placeholder="Buscar por lugar o código" autocomplete="off"></x-master.input> --}}
        </div>
        <div tabindex="0" class="w-full shadow card compact dropdown-content bg-base-100 rounded-box">
            <div class="card-body">
                {{-- <div wire:loading>
                    @include('components.loader-horizontal-sm', [$color = "white"])
                </div> --}}
                @forelse ($aviones as $avion)
                    <div
                        wire:key="AvionInput{{$avion->id}}"
                        @if ($avion->nro_asientos >= $minAsientos)
                            class="cursor-pointer" wire:click="selectAvion({{$avion->id}})"
                        @else
                            class="bg-gray-100"
                        @endif
                    >
                        <x-master.item class="py-1 px-2 my-1 hover:bg-gray-50" label="{{ $avion->descripcion }}">
                            <x-slot name="avatar">
                                <i class="la la-plane"></i>
                            </x-slot>
                            <x-slot name="sublabel">
                                <strong>Matricula: </strong> {{$avion->matricula}} <br>
                                <strong>Nro asientos: </strong> {{$avion->nro_asientos}}
                            </x-slot>
                            <x-slot name="actions">
                                @if ($avion->nro_asientos < $minAsientos)
                                    <div class="badge badge-error badge-outline">Asientos insuficientes</div>
                                @endif
                            </x-slot>
                        </x-master.item>
                    </div>
                @empty
                    Sin resultados
                @endforelse
                @if (count($aviones) == 5)
                    <div class="py-1 px-2 text-center text-gray-300">
                        Resultado limitado a 5 items
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
