<div class="tabs">
    <template x-for="tarifa in $store.adquisicionPasaje.tarifas">
        <a @click="tab = tarifa.descripcion" class="tab tab-lg tab-bordered"
            :class="tab === tarifa.descripcion ? 'tab-active' : ''">
            <i class="la la-user"></i>&nbsp;
            <span x-text="tarifa.descripcion"></span>
            <span
                :class="$store.adquisicionPasaje.isTarifaCompleted(tarifa) ? 'badge-accent' :
                    'badge-outline badge-accent'"
                class="badge ml-1" x-text="tarifa.pasajeros.length+'/'+tarifa.nro"></span>
        </a>
    </template>
</div>
