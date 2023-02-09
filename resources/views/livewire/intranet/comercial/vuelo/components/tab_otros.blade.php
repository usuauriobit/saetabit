<div>
    <x-master.item class="mb-4" label="Otros" sublabel="Otras opciones">
        <x-slot name="avatar">
            <i class="las la-exclamation-triangle"></i>
        </x-slot>
        <x-slot name="actions">
            <a class="btn btn-danger"href="#modalEliminar">
                <i class="la la-trash"></i> Eliminar este vuelo
            </a>

        </x-slot>
    </x-master.item>


    <div class="card-white">
        <div class="card-body">
            <div class="text-red-500">
                <p>
                    Recuerda que al eliminar este vuelo, también se eliminará toda su relación de datos como
                    <strong>Pasajeros, cargas, tripulacion, etc</strong>
                </p>
                <p>
                    Además, al eliminar este vuelo <strong>NO</strong>
                </p>
            </div>
        </div>
    </div>
</div>
