<div class="m-10">
    <h1 class="mb-5 text-2xl">Simple Modal with AlpineJS</h1>
    <!-- Modal -->
    <div x-data="{ showModal : false }">
        <!-- Button -->
        <button @click="showModal = !showModal" class="px-4 py-2 text-sm font-bold text-gray-500 transition-colors duration-150 ease-linear bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-0 hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Open Modal</button>

        <!-- Modal Background -->
        <div x-show="showModal" class="fixed top-0 bottom-0 left-0 right-0 z-50 flex items-center justify-center overflow-auto text-gray-500 bg-black bg-opacity-40"
            x-transition:enter="transition ease duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <!-- Modal -->
            <div x-show="showModal" class="p-6 mx-10 bg-white shadow-2xl rounded-xl sm:w-10/12"
                @click.away="showModal = false"
                x-transition:enter="transition ease duration-100 transform"
                x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease duration-100 transform"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                <!-- Title -->
                <span class="block mb-3 text-2xl font-bold">🍺 Beer, beer, beer </span>
                <!-- Some beer 🍺 -->
                <p class="mb-5">beer, beer, beer... beer, beer, beer... beer, beer, beer... beer, beer, beer...</p>
                <p>beer, beer, beer... beer, beer, beer... beer, beer, beer... beer, beer, beer... beer, beer, beer... beer, beer, beer... beer, beer, beer...</p>

                <!-- Buttons -->
                <div class="mt-5 space-x-5 text-right">
                    <button @click="showModal = !showModal" class="px-4 py-2 text-sm font-bold text-gray-500 transition-colors duration-150 ease-linear bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-0 hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Cancel</button>
                    <a href="https://www.buymeacoffee.com/fricki" target="_blank" class="px-4 py-2 text-sm font-bold text-gray-500 transition-colors duration-150 ease-linear bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-0 hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">🍺 Buy me a beer!</a>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-10 mb-10 border-b border-gray-200"></div>

</div>
