<div x-data>
    <div class="pt-6">
        <x-master.item label="{{ 'Registro de movimiento' }}" :sublabel="$caja->descripcion">
        </x-master.item>
    </div>
    <div class="mt-2 mb-2 shadow-lg alert alert-info">
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="flex-shrink-0 w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          <span>Lista de Ventas que no figuran con movimientos en caja</span>
        </div>
      </div>
    {{-- <div class="my-4 tabs tabs-boxed">
        <a class="tab" :class="{ 'tab-active' : $wire.tab == 'ingreso' }" @click="$wire.setTab('ingreso')">Ingreso</a>
        <a class="tab" :class="{ 'tab-active' : $wire.tab == 'salida' }" @click="$wire.setTab('salida')">Salida</a>
    </div> --}}

    {{-- @if ($tab == 'ingreso') --}}
        {{-- @include('livewire.intranet.caja.caja-movimiento.components.section-types-ingreso') --}}

        <livewire:intranet.caja.caja-movimiento.components.section-venta />
        {{-- @switch($type)
            @case('venta')
                @break
            @case(2)

                @break
            @default

        @endswitch --}}
    {{-- @endif --}}

    {{-- @if ($tab == 'salida')
        <div>
            Salida
        </div>
    @endif --}}

</div>
