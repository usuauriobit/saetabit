<div class="w-full ">
    <div class="w-full dropdown" >
        <div tabindex="0" class="w-full">
            <label class="block mb-2 text-sm font-bold text-gray-700" for="username">
                {{ $label }}
            </label>
            <input wire:model.debounce.700ms="search"
                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                type="text"
                placeholder="Escribe el distrito, provincia, departamento o código" >
        </div>
        <div tabindex="0" class="overflow-y-scroll shadow card compact dropdown-content bg-base-100 rounded-box" style="width: 300pt; max-height: 450pt">
            <div class="card-body">
                <div wire:loading class="mb-2">
                    @include('components.loader-horizontal-sm')
                </div>
                @forelse ($ubigeos as $ubigeo)
                    <button type="button" wire:click="selectUbigeo({{$ubigeo->id}})" class="py-4 text-left btn-ghost">
                        <x-master.item
                            label="{{ $ubigeo->distrito }}"
                            sublabel='{{ "{$ubigeo->provincia}, {$ubigeo->departamento}" }}'/>
                    </button>
                @empty
                    @if (strlen($search) > 4)
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
