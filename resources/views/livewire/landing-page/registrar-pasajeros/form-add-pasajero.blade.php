<div class="card card-white">
    <div class="card-body" x-data="formAddPasajero">
        <div class="text-h5 font-bold">
            <h5 x-text="'Registro de pasajero '+tarifa.descripcion"></h5>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <x-master.select x-model="tipo_documento_id" val="descripcion" :options="$tipo_documentos" label="Tipo de documento"
                name="tipo_documento_id" />
            <x-master.input x-bind:type="nro_documento_type" x-model="nro_documento" label="Nro doc" name="nro_documento" />
        </div>
        <x-master.input label="Nombres" name="nombre" x-model="nombre" />
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <x-master.input x-model="apellido_paterno" label="Apellido paterno" name="apellido_paterno" />
            <x-master.input x-model="apellido_materno" label="Apellido materno" name="apellido_materno" />
        </div>
        <x-master.input type="date" label="Fecha de nacimiento" name="fecha_nacimiento" x-model="fecha_nacimiento" />
        <button class="btn btn-primary w-full mt-4" x-on:click="save(tarifa, $wire)">
            Registrar
        </button>
    </div>
</div>
