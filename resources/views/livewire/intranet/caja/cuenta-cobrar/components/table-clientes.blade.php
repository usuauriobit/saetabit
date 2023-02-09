<x-master.datatable :items="$clientes">
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>N° RUC</th>
            <th>Razón Social</th>
            <th></th>
        </tr>
    </x-slot>
    <x-slot name="tbody">
        @foreach ($clientes as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->ruc }}</td>
                <td>{{ $row->razon_social }}</td>
                <td class="text-center">
                    <button wire:click="addCliente('{{Str::afterLast(get_class($row), "\\")}}','{{$row->id}}')" class="mr-2 btn btn-success btn-sm">
                        <i class="la la-check"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-master.datatable>
