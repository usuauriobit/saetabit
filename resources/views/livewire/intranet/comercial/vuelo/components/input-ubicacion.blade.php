<div class="w-full " x-data="{
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
                {{$label}}
            </label>
            <input wire:model.debounce.600ms="search_ubicacion"
                x-on:keyup="handleOnChange"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                type="text"
                placeholder="Escribe el código, lugar o pista">
        </div>
        <div tabindex="0" class="w-full shadow card compact dropdown-content bg-base-100 rounded-box">
            <div class="card-body">
                @forelse ($ubicacions as $ubicacion)
                    <div  class="cursor-pointer" href="#" wire:click="selectUbicacion({{$ubicacion->id}})">
                        <x-item.ubicacion :ubicacion="$ubicacion"></x-item.ubicacion>
                    </div>
                @empty
                    Sin resultados
                @endforelse
            </div>
        </div>
    </div>
</div>
