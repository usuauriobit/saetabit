<x-master.item class="py-4" label="{{ ucfirst('Encomiendas') }}" sublabel="Lista de Encomiendas">
    <x-slot name="avatar"><i class="text-xl la la-list"></i></x-slot>
</x-master.item>
<div class="card-white ">
    <div class="card-body">
        <div>
            <div class="mt-2 overflow-x-auto">
                <x-master.datatable :items="$guias">
                    <x-slot name="actions">
                    </x-slot>
                    <x-slot name="thead">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Cod.</th>
                            <th class="text-center">Origen</th>
                            <th class="text-center">Destino</th>
                            <th class="text-center">Remitente</th>
                            <th class="text-center">Consignatario</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Fecha Entrega</th>
                            <th class="text-center">Importe (S/.)</th>
                            <th class="text-center">Estado</th>
                            <th></th>
                        </tr>
                    </x-slot>
                    <x-slot name="tbody">
                        @foreach ($guias as $guia)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $guia->codigo }}</td>
                                <td>{{ $guia->origen->distrito }}</td>
                                <td>{{ $guia->destino->distrito }}</td>
                                <td>{{ $guia->remitente->nombre_completo }}</td>
                                <td>{{ $guia->consignatario->nombre_completo }}</td>
                                <td>{{ $guia->fecha->format('d-m-Y') }}</td>
                                <td>{{ optional($guia->fecha_entrega ?? null)->format('d-m-Y') ?? null }}</td>
                                <td>@soles($guia->total)</td>
                                <td>
                                    <div class="badge {{$guia->status_badge_color}}"> {{$guia->status}} </div>
                                </td>
                                <td class="w-3">
                                    <a href="{{ route('intranet.tracking-carga.guia-despacho.show', $guia) }}"
                                        class="btn btn-primary btn-rounded btn-sm" target="_blank">
                                        <i class="text-lg la la-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-master.datatable>
            </div>
        </div>
    </div>
</div>
