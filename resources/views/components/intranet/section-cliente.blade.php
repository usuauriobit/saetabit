<div>
    <div class="h-full card-white">
        <div class="card-body">
            <h4 class="text-lg font-bold">Registro del comprador</h4>
            @if ($cliente)
                <div class="flex items-center justify-between">
                    <h5 class="font-bold">Datos del cliente</h5>
                    <button class="btn btn-outline btn-sm" wire:click="removeCliente">
                        <i class="la la-trash"></i>
                    </button>
                </div>
                @if (get_class($cliente) == 'App\Models\Persona')
                    <x-master.item class="my-2" label="Documento" sublabel="{{$cliente->nro_doc}} - ({{optional($cliente->tipo_documento)->descripcion}})">
                        <x-slot name="avatar"> <i class="la la-address-card"></i> </x-slot>
                    </x-master.item>
                    <x-master.item class="my-2" label="Nombre" :sublabel="$cliente->nombre_short">
                        <x-slot name="avatar"> <i class="la la-user"></i> </x-slot>
                    </x-master.item>
                @else

                <x-master.item class="my-2" label="Razon social" :sublabel="$cliente->razon_social">
                    <x-slot name="avatar"> <i class="la la-building"></i> </x-slot>
                </x-master.item>
                @endif
            @else
                <livewire:intranet.components.input-persona
                    is-cliente
                    emit-event="clienteSelected"
                    :no-ruc="$no_ruc ?? false"
                />
            @endif
        </div>
    </div>
</div>
