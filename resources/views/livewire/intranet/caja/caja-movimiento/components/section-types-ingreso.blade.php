<div class="my-4">
    <button class="p-4 mt-2 badge badge-accent {{$type !== 'venta' ? 'badge-outline' : ''}}"
        wire:click="setType('venta')"
    > Ventas
    </button>
    <button class="p-4 mt-2 badge badge-accent {{$type !== 'otro' ? 'badge-outline' : ''}}"
        wire:click="setType('otro')"
    > Otro
    </button>

</div>
