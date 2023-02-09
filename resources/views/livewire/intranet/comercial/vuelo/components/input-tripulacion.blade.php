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
                Buscar tripulación ({{$this->type}})
            </label>
            <input wire:model.debounce.600ms="search_tripulacion"
                x-on:keyup="handleOnChange"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                type="text"
                placeholder="Escribe el nombre o licencia ..." >
          {{-- <x-master.input class="w-full" label="Buscar" placeholder="Buscar por lugar o código" autocomplete="off"></x-master.input> --}}
        </div>
        <div tabindex="0" class="w-full shadow card compact dropdown-content bg-base-100 rounded-box">
            <div class="card-body">
                @forelse ($results as $result)
                    <div class="cursor-pointer" wire:click="selectTripulacion({{$result->id}})">
                        <x-master.item class="my-3" label="{{ $result->nombre_completo }}">
                            <x-slot name="avatar">
                                <i class="la la-user"></i>
                            </x-slot>
                            <x-slot name="sublabel">
                                <strong>Nro licencia: </strong> {{$result->nro_licencia}}
                            </x-slot>
                        </x-master.item>
                    </div>
                @empty
                    Sin resultados
                @endforelse
            </div>
        </div>
    </div>
</div>
