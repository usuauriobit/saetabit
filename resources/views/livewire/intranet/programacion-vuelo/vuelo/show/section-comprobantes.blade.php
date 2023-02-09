<div>
    <x-master.item class="cabecera p-6" label="Lista de comprobantes"
        sublabel="Historial de comprobantes asociados al pasaje"></x-master.item>
    @foreach ($vuelo->comprobantes as $title => $comprobantes)
        @if (count($comprobantes) > 0)
            <div class="mb-2 rounded-lg shadow-lg">
                <div class="p-2 rounded-t-lg "
                    style="background-image: url('{{ asset('img/default/colorful3.jpg') }}'); background-position:; background-repeat: no-repeat; background-size: cover;">
                    <div class="p-4 bg-white rounded-md">
                        <x-master.item labelSize="xl" :label="$title"
                            sublabel="Resultados: {{ count($comprobantes) }}" />
                    </div>
                </div>
                <div class="pb-6 bg-white ">
                    {{-- {{ dd($comprobantes) }} --}}
                    @foreach ($comprobantes as $comprobante_respuesta)
                        @isset ($comprobante_respuesta->comprobante)
                            <x-master.item class="px-4 py-2 hover:bg-gray-50" labelSize="lg" :label="optional(optional($comprobante_respuesta->comprobante)->tipo_comprobante)
                                ->descripcion">
                                <x-slot name="sublabel">
                                    <ul class="mt-1 text-slate-400">
                                        <li>
                                            <strong>COD:</strong>
                                            {{ optional($comprobante_respuesta->comprobante)->serie_correlativo }}
                                        </li>
                                        <li>
                                            @if ($comprobante_respuesta->comprobante)
                                                <small>
                                                    @foreach (optional($comprobante_respuesta->comprobante)->detalles as $i)
                                                        {{ $i->descripcion . ' / ' }}
                                                    @endforeach
                                                </small>
                                            @else
                                                <div class="alert alert-error">
                                                    Error obteniendo datos de respuesta de comprobante con ID:
                                                    {{ $comprobante_respuesta->id }}
                                                </div>
                                            @endif
                                        </li>
                                    </ul>

                                </x-slot>
                                <x-slot name="actions">
                                    <div class="w-32 text-right">
                                        @can('intranet.programacion-vuelo.vuelo.comprobantes.download')
                                            <div class="mb-2">
                                                {{ optional(optional($comprobante_respuesta->comprobante)->fecha_emision)->format('Y-m-d') }}
                                                <br>
                                            </div>
                                            @if (isset($comprobante_respuesta->enlace_del_pdf))
                                                <a target="_blank" class="btn btn-sm btn-error btn-outline"
                                                    href="{{ $comprobante_respuesta->enlace_del_pdf }}">
                                                    <i class="text-xl la la-file-pdf"></i>
                                                </a>
                                            @endif
                                        @endcan
                                    </div>
                                </x-slot>
                            </x-master.item>
                        @endisset
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</div>
