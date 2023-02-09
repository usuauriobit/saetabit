<div x-data="{ tab: 'detalle' }" x-cloak>
    <x-master.item label="Guía de despacho" class="col-span-3 my-4">
        <x-slot name="sublabel">
            COD: {{ $guia_despacho->codigo }}
            @include('livewire.intranet.tracking-carga.guia-despacho.components.guia-despacho-status')

        </x-slot>
        <x-slot name="actions">
            <div>
                <div class="dropdown">
                    <div tabindex="0" class="mr-2 btn btn-sm btn-warning"> <i class="las la-print"></i> Imprimir</div>
                    <ul tabindex="0" class="p-2 shadow menu dropdown-content bg-base-100 rounded-box w-52">
                        <li>
                            <a href="#" wire:click="print()"> <i class="las la-print"></i> Recibo</a>
                        </li>
                        <li>
                            <a href="#" wire:click="printSticker()"> <i class="las la-print"></i> Sticker</a>
                        </li>
                    </ul>
                </div>
                @if ($guia_despacho->can_manipulate)
                    <a href="{{ route('intranet.tracking-carga.guia-despacho.edit', $guia_despacho) }}"
                        class="mr-2 btn btn-sm btn-warning"> <i class="las la-pen"></i> Editar</a>
                    <a href="#modalAnularGuiaDespacho" class="mr-2 btn btn-sm btn-error">Anular</a>
                    <button onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()"
                        wire:click="saveGuia({{ $guia_despacho->id }})" class="mr-2 btn btn-sm btn-success"
                        {{ $guia_despacho->detalles->count() == 0 ? 'disabled' : '' }}>
                        <i class="la la-save"></i> Guardar
                    </button>

                    <livewire:intranet.components.modal-password-validation eventName="anularGuiaDespachoConfirmated"
                        modalName="modalAnularGuiaDespacho" eventId="{{ $guia_despacho->id }}" />
                @endif
                <a href="{{ route('intranet.tracking-carga.guia-despacho.index', ['oficina_id' => $guia_despacho->oficina_id]) }}"
                    class="btn btn-sm btn-secondary"> <i class="la la-arrow-left"></i> Volver</a>
            </div>
        </x-slot>
    </x-master.item>
    <div class="card-white">
        <div class="card-body">
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-4">
                {{-- <div class="mb-3 ml-3">{!! DNS1D::getBarcodeHTML($guia_despacho->codigo, 'CODABAR') !!}</div> --}}
                <x-master.item class="my-3" label="Remitente">
                    <x-slot name="sublabel">
                        {{ optional($guia_despacho->remitente)->nombre_completo }} <br>
                        <strong>{{ $guia_despacho->remitente->documento }}</strong>
                        <p class="mt-2 text-gray-400">
                            {{ optional(optional($guia_despacho->origen)->ubigeo)->descripcion }}
                        </p>
                    </x-slot>
                </x-master.item>
                <x-master.item class="my-3" label="Consignatario">
                    <x-slot name="sublabel">
                        {{ optional($guia_despacho->consignatario)->nombre_completo }} <br>
                        <strong>{{ $guia_despacho->consignatario->documento }}</strong>
                        <p class="mt-2 text-gray-400">
                            {{ optional(optional($guia_despacho->destino)->ubigeo)->descripcion }}
                        </p>
                    </x-slot>
                </x-master.item>
                <x-master.item class="my-3" label="Fecha"
                    sublabel="{{ optional($guia_despacho->fecha)->format('Y-m-d') }}"></x-master.item>
                {{-- <x-master.item class="my-3" label="Subtotal" sublabel="{{ $guia_despacho->sub_total }}"></x-master.item> --}}

                @if (!$guia_despacho->is_free)
                    <x-master.item class="my-3" label="Total">
                        <x-slot name="sublabel">
                            @can('intranet.tracking-carga.guia-despacho.show-importe')
                            <strong>
                                @soles($guia_despacho->importe_total) <br>
                            </strong>
                            @endcan
                            {{-- ≈ @soles($guia_despacho->importe_total_soles) --}}
                            @if (!$guia_despacho->is_saved)
                                <br>
                                <small>
                                    * Esto es un cálculo provisional, aún no se genera un registro en venta.
                                    Guarde el documento para obtener el cálculo final.
                                </small>
                            @endif
                        </x-slot>
                    </x-master.item>
                @else
                    <x-master.item class="my-3" label="Total" sublabel="GRATIS"></x-master.item>
                    <x-master.item class="my-3" label="Aprobado por:" sublabel="{{optional($guia_despacho->approved_by)->user_name}}"></x-master.item>

                @endif
            </div>
        </div>
    </div>
    <div class="my-4 tabs tabs-boxed">
        <a class="tab" @click="tab = 'detalle'" :class="{ 'tab-active': tab == 'detalle' }">Detalle</a>
        <a class="tab" @click="tab = 'seguimiento'" :class="{ 'tab-active': tab == 'seguimiento' }">Tracking</a>
    </div>
    <div>
        <div x-show="tab == 'detalle'">
            @include('livewire.intranet.tracking-carga.guia-despacho.components.section-detalle')
        </div>
        <div x-show="tab == 'seguimiento'">
            <livewire:intranet.tracking-carga.components.track-section wire:key="{{ now() }}" :onlyShow="$guia_despacho->is_entregado" :guia-despacho="$guia_despacho" />
        </div>
    </div>

    @include('livewire.intranet.tracking-carga.guia-despacho-detalle.create')
    @include('livewire.intranet.tracking-carga.guia-despacho.components.beforDestroy')
</div>
