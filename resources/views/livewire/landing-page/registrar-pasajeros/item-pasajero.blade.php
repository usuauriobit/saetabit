<div class="flex items-center justify-between">
    <div class="text-h5 font-bold">
        <span>
            Pasajero <span x-text=" tarifa.descripcion + ' ' + (index+1)"></span>
        </span>
    </div>
    <button x-on:click="$store.adquisicionPasaje.deletePasajero(tarifa, pasajero.uid)"
        class="btn btn-outline btn-secondary btn-sm">
        <i class="la la-trash"></i> &nbsp; Eliminar
    </button>
</div>
<div class="my-2">
    <p class="font-medium leading-5 text-gray-800">Tipo de documento</p>
    <p class="text-sm leading-normal text-gray-500" x-text="pasajero.tipo_documento_id"></p>
</div>
<div class="my-2">
    <p class="font-medium leading-5 text-gray-800">Nro doc</p>
    <p class="text-sm leading-normal text-gray-500" x-text="pasajero.nro_documento">
    </p>
</div>
<div class="my-2">
    <p class="font-medium leading-5 text-gray-800">Nombres</p>
    <p class="text-sm leading-normal text-gray-500"
        x-text="pasajero.apellido_paterno+' '+pasajero.apellido_materno+', '+pasajero.nombre">
    </p>
</div>
<div class="my-2">
    <p class="font-medium leading-5 text-gray-800">Fecha de nacimiento</p>
    <p class="text-sm leading-normal text-gray-500" x-text="pasajero.fecha_nacimiento">
    </p>
</div>
<div class="my-2">
    <p class="font-medium leading-5 text-gray-800">Edad</p>
    <p class="text-sm leading-normal text-gray-500" x-text="pasajero.edad">
    </p>
</div>
