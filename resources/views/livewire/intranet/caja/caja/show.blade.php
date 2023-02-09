<div>
    @section('title', __('Caja'))

    @if ($nro_movimientos_sin_facturar > 0)
        <div class="shadow-lg alert alert-warning">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>¡Atención! Tienes movimientos en caja sin facturar.</span>
            </div>
        </div>
    @endif
    @if ($caja_comprobantes->count() == 0)
        <div class="shadow-lg alert alert-warning">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>
                    ¡Atención! Aún no has registrado series de comprobantes para esta caja.
                    Debes registrarlos para poder generar movimientos.
                </span>
            </div>
        </div>
    @endif
    <div class="cabecera p-6">
        <div class="grid grid-cols-4 gap-4 mb-4">
            <x-master.item label="{{ ucfirst('Caja') }}" :sublabel="$caja->descripcion"></x-master.item>
            <x-master.item label="{{ ucfirst('Cajero') }}" :sublabel="Auth::user()->name"></x-master.item>
            <x-master.item label="{{ ucfirst('Tipo') }}" :sublabel="optional($caja->tipo_caja ?? null)->descripcion"></x-master.item>
            <x-master.item label="{{ ucfirst('Serie') }}" :sublabel="$caja->serie"></x-master.item>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <x-master.item label="{{ ucfirst('Fecha Apertura') }}" :sublabel="optional(optional($caja->apertura_pendiente ?? null)->fecha_apertura ?? null)->format('d-m-Y') ?? '-'">
            </x-master.item>
        </div>

        <x-master.item label="{{ ucfirst('Movimientos') }}" sublabel="Lista de movimientos realizados">
            <x-slot name="actions">
                <div>
                    @if ($caja->apertura_pendiente)
                        @can('intranet.comercial.pasaje.create')
                            <a href="{{ route('intranet.comercial.adquisicion-pasaje.create', ['redirectRoute' => route('intranet.caja.caja.show', $caja->id)]) }}"
                                class="mr-2 btn btn-info btn-sm">
                                <i class="la la-plus"></i> Registrar pasaje
                            </a>
                        @endcan
                        @if ($caja_comprobantes->count() > 0)
                            @can('intranet.caja.venta.show')
                                <a href="#createMovimientoModal" class="mr-2 btn btn-primary btn-sm">
                                    <i class="la la-plus"></i> Movimiento
                                </a>
                            @endcan
                        @endif
                        @if ($nro_movimientos_sin_facturar == 0)
                            @can('intranet.caja.caja-apertura-cierre.edit')
                                <a href="{{ route('intranet.caja.caja-apertura-cierre.edit', $caja->getAperturaPendienteAttribute($current_date)) }}"
                                    class="btn btn-error btn-sm">
                                    Cerrar Caja
                                </a>
                            @endcan
                        @endif
                    @else
                        @can('intranet.caja.caja-apertura-cierre.create')
                            <a href="{{ route('intranet.caja.caja-apertura-cierre.create', $caja) }}"
                                class="btn btn-success btn-sm">
                                <i class="la la-pen"></i>
                                Aperturar
                            </a>
                        @endcan
                    @endif
                </div>
            </x-slot>
        </x-master.item>
    </div>
    @include('livewire.intranet.caja.caja.components.create-movimiento')
    <div class="card-white">
        <div class="card-body">
            @include('livewire.intranet.caja.caja.components.table-movimientos')
        </div>
    </div>
    @include('livewire.intranet.caja.caja.components.modal-solicitar-extorno')
</div>
