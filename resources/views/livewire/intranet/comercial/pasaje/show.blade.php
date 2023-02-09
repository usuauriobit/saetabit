<div>
    <div>
        <x-master.item class="cabecera p-6" label="Información del pasaje" sublabel="{{ $pasaje->codigo }}">
            <x-slot name="actions">
                <livewire:intranet.comercial.pasaje.components.action-options :pasaje="$pasaje"
                    wire:key="{{ now() }}" />
            </x-slot>
        </x-master.item>
    </div>
    <livewire:intranet.components.modal-password-validation eventName="anularPasajeConfirmated"
        modalName="modalAnularPasaje" withObservacion eventId="{{ $pasaje->id }}" />
    <div>
        @include('livewire.intranet.comercial.pasaje.show.section-info')
    </div>

    @if (!$pasaje->is_pagado)
    <div class="my-4">
        <div class="alert alert-warning shadow-lg">
            <div>
              <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
              <span>Este pasaje aún no ha sido pagado</span>
            </div>
        </div>
    </div>
    @endif

    <div class="tabs tabs-boxed">
        @if ($this->can_registrar_cambios_pasaje)
            @can('intranet.comercial.pasaje.cambio.titular.index')
                <a class="tab {{ $tab == 'cambio_titularidad' ? 'tab-active' : '' }}"
                    wire:click="setTab('cambio_titularidad')">Cambio de titular</a>
            @endcan
            @can('intranet.comercial.pasaje.cambio.fecha.index')
                <a class="tab {{ $tab == 'fecha' ? 'tab-active' : '' }}" wire:click="setTab('fecha')">Cambio de fecha</a>
            @endcan
            @can('intranet.comercial.pasaje.cambio.ruta.index')
                <a class="tab {{ $tab == 'ruta' ? 'tab-active' : '' }}" wire:click="setTab('ruta')">Cambio de ruta</a>
            @endcan
            @can('intranet.comercial.pasaje-abierto.asignar-vuelo')
                <a class="tab {{ $tab == 'asignar_vuelo' ? 'tab-active' : '' }}" wire:click="setTab('asignar_vuelo')">
                    Pasaje abierto
                    @if ($pasaje->is_abierto)
                        <i class="ml-2 text-red-500 las la-dot-circle"></i>
                    @endif
                </a>
            @endcan
        @endif
        @can('intranet.comercial.pasaje.comprobantes.index')
            <a class="tab {{ $tab == 'comprobantes' ? 'tab-active' : '' }}" wire:click="setTab('comprobantes')">
                Comprobantes
            </a>
        @endcan
        <a class="tab" wire:loading>
            @include('components.loader-horizontal-sm')
        </a>
    </div>

    <div>
        @switch($tab)
            @case('cambio_titularidad')
                @can('intranet.comercial.pasaje.cambio.titular.index')
                    @if (!$pasaje->is_abierto)
                        <livewire:intranet.comercial.pasaje.show.section-cambio-titularidad :pasaje_id="$pasaje->id" />
                    @else
                        <div class="mt-4 shadow-lg alert alert-info">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    class="flex-shrink-0 w-6 h-6 stroke-current">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Los pasajes de fecha abierta no pueden realizar esta acción</span>
                            </div>
                        </div>
                    @endif
                @endcan
            @break

            @case('fecha')
                @can('intranet.comercial.pasaje.cambio.fecha.index')
                    @if (!$pasaje->is_abierto)
                        <livewire:intranet.comercial.pasaje.show.section-cambio-fecha :pasaje_id="$pasaje->id" />
                    @else
                        <div class="mt-4 shadow-lg alert alert-info">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    class="flex-shrink-0 w-6 h-6 stroke-current">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Los pasajes de fecha abierta no pueden realizar esta acción</span>
                            </div>
                        </div>
                    @endif
                @endcan
            @break

            @case('ruta')
                @can('intranet.comercial.pasaje.cambio.ruta.index')
                    @if (!$pasaje->is_abierto)
                        <div wire:key="sectionCambioRutaCard">
                            <livewire:intranet.comercial.pasaje.show.section-cambio-ruta :pasaje_id="$pasaje->id" />
                        </div>
                    @else
                        <div class="mt-4 shadow-lg alert alert-info">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    class="flex-shrink-0 w-6 h-6 stroke-current">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Los pasajes de fecha abierta no pueden realizar esta acción</span>
                            </div>
                        </div>
                    @endif
                @endcan
            @break

            @case('asignar_vuelo')
                <div wire:key="sectionCambioRutaCard">
                    <livewire:intranet.comercial.pasaje.show.section-asignar-vuelo :pasaje="$pasaje"
                        wire:key="{{ now() }}" />
                </div>
            @break

            @case('comprobantes')
                @can('intranet.comercial.pasaje.comprobantes.index')
                    <div wire:key="sectionComprobantes">
                        @include('livewire.intranet.comercial.pasaje.show.section-comprobantes')
                    </div>
                @endcan
            @break

            @default
        @endswitch
    </div>
</div>
