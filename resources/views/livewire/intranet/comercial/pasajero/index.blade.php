<div>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Edad</th>
                        <th>Nro pasajes</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($personas as $persona)
                        <tr>
                            <td>{{ $persona->nombre_completo }}</td>
                            <td>{{ $persona->edad }}</td>
                            <td>{{ $persona->pasajes->count() }}</td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{ route('intranet.comercial.pasajero.show', $persona->id) }}">
                                    <i class="la la-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
