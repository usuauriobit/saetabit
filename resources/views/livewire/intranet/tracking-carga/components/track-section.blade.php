<div class="card-white">
    @if ($showAlerts)
        @include('livewire.intranet.tracking-carga.components.track-section.alerts')
    @endif
    <div class="card-body">
        <div class="flex items-center mb-4 justify-content-between">
            <div class="flex-1">
                <span class="font-bold">Seguimiento de guía de despacho</span>
                <p class="text-gray-500">COD: {{ $guiaDespacho->codigo }}</p>
            </div>
            @if (!$onlyShow)
                <a href="{{ route('intranet.tracking-carga.guia-despacho.show', $guiaDespacho) }}" class="btn btn-primary btn-sm">
                    <i class="text-lg la la-eye"></i>
                </a>
            @endif
        </div>

        @if (!$onlyShow)
            @if (!$guiaDespacho->is_entregado )
                <div class="grid grid-cols-2 gap-4 my-2">
                    <a href="#registrarMovimientoModal" class="w-full btn btn-outline btn-primary">
                        Registrar movimiento
                    </a>
                    <div>
                        <button wire:click="registrarEntrega" onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()" class="w-full btn btn-primary">
                            Registrar entrega
                        </button>
                        @if (!$guiaDespacho->is_in_destino)
                            <div class="text-error text-sm">NOTA: El paquete aún no llega a su destino</div>
                        @endif
                    </div>
                </div>
            @endif
        @endif

        @if (!$onlyShow)
            <x-master.modal id-modal="registrarMovimientoModal">
                <div wire:loading class="w-full">
                    <div class="loader">Cargando...</div>
                </div>
                <div wire:loading.remove>
                    <livewire:intranet.tracking-carga.guia-despacho.components.create-movimiento :guia-despacho="$guiaDespacho" />
                </div>
            </x-master.modal>
        @endif

        <ul class="steps steps-vertical ">
            <li class=" step step-primary"
                data-content="✓">
                <div class="w-full text-left ">
                    <x-master.item sublabel="COD: {{$guiaDespacho->codigo}}" >
                        <x-slot name="label">
                            <strong>({{ optional(optional($guiaDespacho->oficina)->ubigeo)->distrito }})</strong>
                            Recepcionado
                        </x-slot>
                        <x-slot name="actions">
                            <span class="text-sm text-gray-500">{{optional($guiaDespacho->fecha)->format('Y-m-d g:i a')}}</span>
                        </x-slot>
                    </x-master.item>
                </div>
            </li>
            @foreach ($guiaDespacho->guia_despacho_steps as $step)
                <li class=" step step-primary"
                    data-content="✓">
                    <div class="w-full text-left ">
                        <x-master.item sublabel="COD: {{$step->codigo}}" >
                            <x-slot name="label">
                                <strong>({{$step->distrito}})</strong>
                                {{$step->is_vuelo ? 'En vuelo' : 'En oficina / Almacén'}}
                            </x-slot>
                            <x-slot name="actions">
                                <span class="text-sm text-gray-500">{{optional($step->fecha)->format('Y-m-d g:i a')}}</span>
                            </x-slot>
                        </x-master.item>
                    </div>
                </li>
            @endforeach
            <li class="step {{$guiaDespacho->is_entregado ? 'step-primary' : ''}}"
                data-content="{{$guiaDespacho->is_entregado ? '✓' : '●'}} ">
                <div class="w-full text-left ">
                    <x-master.item sublabel="COD: {{$guiaDespacho->codigo}}" >
                        <x-slot name="label">
                            {{$guiaDespacho->is_entregado ? 'Entregado' : 'Pendiente de entrega'}}
                        </x-slot>
                        <x-slot name="actions">
                            <span class="text-sm text-gray-500">{{optional($guiaDespacho->is_entregado)->format('Y-m-d') ?? '--'}}</span>
                        </x-slot>
                    </x-master.item>
                </div>
            </li>
        </ul>
    </div>
</div>
