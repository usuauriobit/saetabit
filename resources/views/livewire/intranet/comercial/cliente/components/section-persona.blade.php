<div>
    <div class="card-white">
        <div class="card-body">
            <x-master.datatable :items="$personas">
                <x-slot name="actions">
                </x-slot>
                <x-slot name="thead">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Tipo doc</th>
                        <th class="text-center">Nro doc</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Edad</th>
                        <th class="text-center">Sexo</th>
                        <th class="text-center">Teléfono</th>
                        <th class="text-center">F. Nac</th>
                        <th class="text-center">Distrito</th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($personas as $row)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ optional($row->tipo_documento)->descripcion }}</td>
                            <td class="text-center">{{ $row->nro_doc }}</td>
                            <td>{{ $row->nombre_completo }}</td>
                            <td class="text-center">{{ $row->edad }}</td>
                            <td class="text-center">{{ $row->sexo_desc }}</td>
                            <td class="text-center">{{ $row->ultimo_telefono }}</td>
                            <td class="text-center">{{ optional($row->fecha_nacimiento)->format('d-m-Y') }}</td>
                            <td class="text-center">{{ optional($row->ubigeo)->distrito }}</td>
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
