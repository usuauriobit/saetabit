<div>
    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$items">
                <x-slot name="thead">
                    <tr>
                        <th>#</th>
                        <th>Venta N°</th>
                        <th>Cliente</th>
                        <th>Importe</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach($items as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td> {{ $row->codigo }} </td>
                            <td> {{ $row->clientable->nombre_completo }} </td>
                            <td class="text-right"> {{ 'S/. ' . number_format($row->importe, 2, '.', ',') }} </td>
                            <td class="w-3">
                                <button href="" class="btn btn-outline btn-circle btn-success">
                                    <i class="la la-check"></i>
                                </button>
                                {{-- <a href="{{ route('intranet.comercial.vuelo.show', $row) }}"
                                    class="btn btn-circle btn-sm btn-success">
                                    <i class="la la-eye"></i>
                                </a> --}}
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
