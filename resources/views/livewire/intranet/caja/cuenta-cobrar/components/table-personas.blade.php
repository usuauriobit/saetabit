<x-master.datatable :items="$personas">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>N° Doc</th>
            <th>Nombre</th>
            <th></th>
        </tr>
    </x-slot>
    <x-slot name="tbody">
        @foreach ($personas as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->nro_doc }}</td>
                <td>{{ $row->nombre_completo }}</td>
                <td class="text-center">
                    <button wire:click="addCliente('{{Str::afterLast(get_class($row), "\\")}}','{{$row->id}}')" class="mr-2 btn btn-success btn-sm">
                        <i class="la la-check"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-master.datatable>
