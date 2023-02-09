<div class="flex justify-center p-12">
    <!-- Dropdown -->
    <div x-data="{ open: false }" class="relative">
        <button x-on:click="open = true" class="block w-12 h-12 overflow-hidden rounded-full focus:outline-none">
            <img class="object-cover w-full h-full" src="https://eu.ui-avatars.com/api/?name=John&size=1000" alt="avatar">
        </button>
        <!-- Dropdown Body -->
        <div x-show="open" x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-on:click.away="open = false"
        class="absolute right-0 w-40 py-2 mt-2 bg-white border rounded shadow-xl">
            <a href="#" class="block px-4 py-2 text-gray-900 transition-colors duration-200 rounded text-normal hover:bg-purple-500 hover:text-white">Settings</a>
            <div class="py-2">
            </div>
            <a href="#" class="block px-4 py-2 text-gray-900 transition-colors duration-200 rounded text-normal hover:bg-purple-500 hover:text-white">
                Logout
            </a>
        </div>
    <!-- // Dropdown Body -->
    </div>
    <!-- // Dropdown -->
  </div>
