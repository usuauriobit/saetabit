<div x-data="{showOptions: false}">
    <label id="listbox-label" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <div class="relative mt-1">
        <button @click="showOptions = !showOptions" @click.outside="showOptions = false" type="button" class="relative w-full py-2 pl-3 pr-10 text-left bg-white border border-gray-300 rounded-md shadow-sm cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
            @if ($ubicacion)
                <div style="margin-bottom: -4pt">
                    <x-item.ubicacion onlyDistrito hideCodigo :ubicacion="$ubicacion">
                        <x-slot name="actions">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-2 ml-3 pointer-events-none">
                                <!-- Heroicon name: solid/selector -->
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </x-slot>
                    </x-item.ubicacion>
                </div>
            @else
                <span class="flex items-center">
                    <span class="block ml-3 truncate"> {{$placeholder}} </span>
                </span>
                <span class="absolute inset-y-0 right-0 flex items-center pr-2 ml-3 pointer-events-none">
                    <!-- Heroicon name: solid/selector -->
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </span>
            @endif
        </button>

      <ul x-show="showOptions" x-cloak class="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-option-3">
        @forelse ($ubicacions as $ubicacion)
            <li>
                <div wire:key='{{$eventName}}{{$loop->iteration}}' class="px-2 py-1 cursor-pointer hover:bg-gray-100" href="#" wire:click="{{$eventName}}({{$ubicacion->id}})">
                    <x-item.ubicacion wire:key='u{{$eventName}}{{$loop->iteration}}' :ubicacion="$ubicacion"></x-item.ubicacion>
                </div>
            </li>
        @empty
            <li>
                <div class="my-2 text-center">
                    <strong>Sin resultados</strong>
                </div>
            </li>
        @endforelse
      </ul>
    </div>
  </div>
