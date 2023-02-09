<div x-data="{
    showOptions: false,
    nro_pasajes: @entangle('nro_pasajes').defer,
    add: (nro_pasaje, nro_total) => {
        if (nro_total >= 5) {
            return
        }
        nro_pasaje.nro++
    },
    sub: (nro_pasaje, nro_total) => {
        if (nro_total <= 1) {
            return
        }
        nro_pasaje.nro--
    },
    get nro_total() {
        return this.nro_pasajes.reduce((acum, e) => acum += parseInt(e.nro), 0)
    },
    {{-- handleOutside: (e) => {
        showOptions = false
        console.log('PASASE', e)
    } --}}
}" x-cloak x-init="() => {
    {{-- nro_pasajes =
        console.log(nro_pasajes) --}}
}" @click.outside="showOptions = false;">
    <label id="listbox-label" class="block text-sm font-medium text-gray-700">Nro pasajeros</label>
    <div class="relative mt-1">
        <button @click="showOptions = !showOptions" type="button"
            class="relative w-full py-2 pl-3 pr-10 text-left rounded-md cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
            <span class="flex items-center">
                <i class="la la-user"></i> &nbsp;
                <span x-text="nro_total"></span>
            </span>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 ml-3 pointer-events-none">
                <!-- Heroicon name: solid/selector -->
                <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </span>
        </button>
        <ul x-show="showOptions" x-cloak
            class="absolute z-10 min-w-full w-80 min:w-65 py-1 mt-1 overflow-auto  bg-white rounded-md shadow-lg max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none "
            tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-option-3">
            <template x-for="nro_pasaje in nro_pasajes">
                <li>
                    <div class="px-2 py-3 cursor-pointer hover:bg-gray-100" href="#">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-base sm:text-sm">
                                    <i class="la la-user"></i>
                                    <span x-text="nro_pasaje.descripcion"></span>
                                </div>
                                <div class="text-stone-400 text-xs mt-1">
                                    <template x-if="nro_pasaje.edad_minima == 0">
                                        <span>Menor de <span x-text="nro_pasaje.edad_maxima"></span></span>
                                    </template>
                                    <template x-if="nro_pasaje.edad_maxima > 100">
                                        <span>Mayor de <span x-text="nro_pasaje.edad_minima"></span></span>
                                    </template>
                                    <template x-if="nro_pasaje.edad_maxima < 100 && nro_pasaje.edad_minima > 0">
                                        <span
                                            x-text="'Entre '+nro_pasaje.edad_minima + ' y ' + (nro_pasaje.edad_maxima)+' años'"></span>
                                    </template>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <button x-bind:disabled="nro_pasaje.nro <= 0"
                                    @click="sub(nro_pasaje, nro_total); $wire.setNroPasajes(nro_pasajes)" type="button"
                                    class="btn btn-outline btn-sm btn-circle btn-primary">
                                    -
                                </button>
                                <span x-text="nro_pasaje.nro"></span>
                                <button x-bind:disabled="nro_total >= 5"
                                    @click="add(nro_pasaje, nro_total); $wire.setNroPasajes(nro_pasajes)" type="button"
                                    class="btn btn-outline btn-sm btn-circle btn-primary">
                                    +
                                </button>
                            </div>
                        </div>

                        <div class="alert alert-info mt-2" x-show="!nro_pasaje.ocupa_asiento && nro_pasaje.nro > 0">
                            Este pasaje no ocupará asiento, por lo que el bebé solo podrá viajar en el regazo
                            del adulto.
                        </div>
                    </div>
                </li>
            </template>
            {{-- <li>
                <button class="w-full px-4 py-3 font-bold text-blue-500 transition duration-300 ease-in-out border-2 border-blue-500 rounded-lg hover:bg-blue-500 hover:text-white"
                    type="button"
                    @click="$wire.setNroPasajes(nro_pasajes)">
                    Guardar
                </button>
            </li> --}}
        </ul>
    </div>
</div>
