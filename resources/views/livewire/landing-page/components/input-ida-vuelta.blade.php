<div x-data="{showOptions: false}">
    <label id="listbox-label" class="block text-sm font-medium text-gray-700">Tipo</label>
    <div class="relative mt-1">
        <button @click="showOptions = !showOptions" @click.outside="showOptions = false" type="button" class="relative w-full py-2 pl-3 pr-10 text-left rounded-md cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
            <span class="flex items-center">
                {{-- <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="flex-shrink-0 w-6 h-6 rounded-full"> --}}
                <span class="block ml-3 truncate"> {{$is_ida_vuelta ? 'Ida y vuelta' : 'Solo ida'}} </span>
            </span>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 ml-3 pointer-events-none">
                <!-- Heroicon name: solid/selector -->
                <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </span>
        </button>
      <ul x-show="showOptions" x-cloak class="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-option-3">
        <li>
            <div class="px-4 py-2 cursor-pointer hover:bg-gray-100" href="#" wire:click="setIsIdaVuelta()">
                Ida y vuelta
            </div>
        </li>
        <li>
            <div class="px-4 py-2 cursor-pointer hover:bg-gray-100" href="#" wire:click="setIsSoloIda()">
                Solo ida
            </div>
        </li>
      </ul>
    </div>
  </div>
