<div class="w-full" x-data="{
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
                Buscar tramo
            </label>
            <input wire:model.debounce.600ms="search_tramo"
                x-on:keyup="handleOnChange"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                type="text"
                placeholder="Escribe el distrito" >
        </div>
        <div tabindex="0" class="overflow-y-scroll shadow card compact dropdown-content bg-base-100 rounded-box" style="width: 450pt; max-height: 450pt">
            <div class="card-body">
                <div wire:loading class="mb-2">
                    @include('components.loader-horizontal-sm')
                </div>
                @forelse ($tramos as $tramo)
                    <a href="#" wire:click="selectTramo({{$tramo->id}})" class="my-4">
                        {{$tramo->origen->distrito}},
                        @if ($tramo->escala)
                            {{$tramo->escala->distrito}},
                        @endif
                        {{$tramo->destino->distrito}}
                    </a>
                @empty
                    @if (strlen($search_tramo) > 4)
                        No se encontraron resultados
                    @else
                        <span class="text-gray-600 text-md">
                            <i class="la la-search"></i> &nbsp;
                            Escriba almenos dos letras para realizar la búsqueda.
                        </span>
                    @endif
                @endforelse
            </div>
        </div>
    </div>
</div>
