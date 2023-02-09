<div>
    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$empresas">
                <x-slot name="actions">
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Tipo doc</th>
                        <th class="text-center">Nro Documento</th>
                        <th class="text-center">Razón Social</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($empresas as $row)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ 'RUC' }}</td>
                            <td class="text-center">{{ $row->ruc }}</td>
                            <td>{{ $row->razon_social }}</td>
                            <td class="w-3">
                                @can('intranet.comercial.cliente.show')
                                    <a href="{{ route('intranet.comercial.cliente.show', [
                                        'cliente_id' => $row->id,
                                        'cliente_model' => str_replace('App\\Models\\', '', get_class($row)),
                                    ]) }}"
                                        class="btn btn-primary btn-rounded btn-sm">
                                        <i class="text-lg la la-eye"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-master.datatable>
        </div>
    </div>
</div>
