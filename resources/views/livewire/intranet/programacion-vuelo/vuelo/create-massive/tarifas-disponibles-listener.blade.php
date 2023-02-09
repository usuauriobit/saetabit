<div>
    @if (count($result) > 0)
    <div class="mb-2 alert alert-warning">
        <strong>Tenga en cuenta:</strong>
        <p>
            <ul>
                @foreach ($result as $tipo_pasaje)
                    <li>
                        No existe una tarifa asignada para el tipo de pasaje: {{$tipo_pasaje}}
                        en la ruta seleccionada.
                    </li>
                @endforeach
            </ul>
        </p>
    </div>
    @endif
</div>
