<div class="cabecera p-6 ">
    <x-master.item class="mb-2" label="Resumen de pasajes adquiridos">
        <x-slot name="sublabel">
            Resumen por fechas y rutas, en el rango de fechas de {{ $fecha_inicio }} al
            {{ $fecha_final }}
        </x-slot>
        <x-slot name="actions">
            <div class="flex gap-4">
                <x-master.input label="Fecha de inicio" wire:model="fecha_inicio" type="date"></x-master.input>
                <x-master.input label="Fecha final" wire:model="fecha_final" type="date"></x-master.input>
            </div>
        </x-slot>
    </x-master.item>
    <div class="overflow-x-auto">
        <table class="table w-full table-zebra">
            <thead>
                <tr>
                    <th>Ruta</th>
                    @php $fecha_current = \Carbon\Carbon::create($this->fecha_inicio); @endphp
                    @while ($fecha_current->lessThanOrEqualTo($this->fecha_final_corregido))
                        <th>
                            {{ $fecha_current->dayName }}
                            <br>
                            {{ $fecha_current->format('d/m/Y') }}
                        </th>
                        @php $fecha_current->addDay(); @endphp
                    @endwhile
                </tr>
            </thead>
            <tbody>
                @foreach ($result as $vuelo_cod => $fechas)
                    <tr>
                        <th>{!! $vuelo_cod !!}</th>
                        @php $fecha_current = \Carbon\Carbon::create($this->fecha_inicio); @endphp
                        @while ($fecha_current->lessThanOrEqualTo($this->fecha_final_corregido))
                            @isset($fechas[$fecha_current->format('Y-m-d')])
                                @foreach ($fechas[$fecha_current->format('Y-m-d')] as $vuelo)
                                    <td class="text-center">
                                        <progress class="w-10 progress progress-primary"
                                            value="{{ $vuelo->nro_asientos_ocupados }}"
                                            max="{{ $vuelo->nro_asientos_ofertados }}">
                                        </progress>
                                        @php
                                            $cod = uniqid();
                                        @endphp
                                        <a href="#{{ $cod }}">
                                            <i class="la la-info"></i>
                                        </a>
                                        <x-master.modal wSize="4xl" :idModal="$cod" label="Información">
                                            <div class="text-left">
                                                <strong>
                                                    Vuelo:
                                                    @can('intranet.programacion-vuelo.vuelo.show')
                                                        <a href="{{ route('intranet.programacion-vuelo.vuelo.show', $vuelo) }}">
                                                            {{ $vuelo->codigo }}
                                                        </a>
                                                    @else
                                                        {{ $vuelo->codigo }}
                                                    @endcan
                                                    <x-item.vuelo-horizontal :vuelo="$vuelo" />
                                                </strong>

                                                <div class="mt-4 mb-2">
                                                    <strong>Resumen de pasajes</strong>
                                                </div>
                                                <ul>
                                                    @forelse ($vuelo->pasajes->groupBy('descuento.descripcion') as $descuento_desc => $pasajes)
                                                        <li class="text-left">
                                                            {{ $descuento_desc == '' ? 'Sin descuento' : $descuento_desc }}
                                                            : {{ $pasajes->count() }}
                                                        </li>
                                                        {{-- <x-master.item>
                                                            <x-slot name="label">
                                                                {{ $descuento_desc == '' ? 'Sin descuento' : $descuento_desc }}
                                                            </x-slot>
                                                            <x-slot name="sublabel">
                                                                {{ $pasajes->count() }}
                                                            </x-slot>
                                                        </x-master.item> --}}
                                                    @empty
                                                        <li>
                                                            <div class="text-center font-bold alert alert-info">
                                                                <div class="mx-auto">
                                                                    Sin resultados
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </x-master.modal>
                                        <br>
                                        {{ $vuelo->nro_asientos_ocupados }}/
                                        {{ $vuelo->nro_asientos_ofertados }}
                                    </td>
                                @endforeach
                            @else
                                <td>-</td>
                            @endisset
                            @php $fecha_current->addDay(); @endphp
                        @endwhile
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
