<div x-data="app()" x-cloak>
    {{-- <x-master.item label="Registrar vuelo" class="py-3">
        <x-slot name="sublabel">
            <span class="font-weight-bold ms-1">Registro de nuevo vuelo
        </x-slot>
        <x-slot name="avatar">
            <i class="text-2xl la la-plane"></i>
        </x-slot>
        <x-slot name="actions">
        </x-slot>
    </x-master.item> --}}
    <div class="card-white">
        <div class="card-body">
            <div class="text-center">
                <h3 class="mb-4 text-xl font-bold text-primary">
                    <i class="text-2xl la la-plane"></i>
                    Registro de vuelo
                </h3>
            </div>
            <ul class="w-full steps">
                <li class="step step-primary">Vuelo</li>
                <li class="step" :class="{'step-primary': step>=2}">Ruta</li>
                <li class="step " :class="{'step-primary': step==3}">Fecha</li>
            </ul>
            <div class="mt-4">

                <div x-show="step==1"
                    x-transition:enter.scale.80.delay.50ms
                    x-transition:leave.scale.90>
                    <div class="grid grid-cols-1 gap-4 mb-4 lg:grid-cols-2">
                        <x-master.select wire:model="form.tipo_vuelo_id" :options="$tipo_vuelo" label="Tipo de vuelo"></x-master.select>
                        <x-master.select wire:model="form.avion_id" :options="$avion" label="Avión"></x-master.select>
                    </div>
                </div>
                <div x-show="step==2"
                    x-transition:enter.scale.80.delay.50ms
                    x-transition:leave.scale.90>
                    <div class="grid grid-cols-1 gap-4 mb-4 lg:grid-cols-2">
                        <x-master.select wire:model="form.origen" :options="$ubicacions" label="Origen"></x-master.select>
                        <x-master.select wire:model="form.destino" :options="$ubicacions" label="Destino"></x-master.select>
                    </div>
                </div>
                <div x-show="step==3"
                    x-transition:enter.scale.80.delay.50ms
                    x-transition:leave.scale.90>
                    <div class="grid grid-cols-1 gap-4 mb-4 lg:grid-cols-2">
                        <x-master.select wire:model="form.fecha_hora_vuelo_programado" label="Fecha y hora de vuelo"></x-master.select>
                        <x-master.select wire:model="form.fecha_hora_aterrizaje_programado" label="Fecha y hora de aterrizaje"></x-master.select>
                    </div>
                </div>
            </div>
            <div class="justify-end card-actions">
                <button
                x-show="step > 1"
                @click="step--"
                class="btn btn-secondary btn-outline">
                    <i class="las la-angle-left"></i>
                    Anterior
                </button>
                <button
                x-show="step < 3"
                @click="step++"
                class="btn btn-primary">
                    Siguiente
                    <i class="las la-angle-right"></i>
                </button>
                <button
                x-show="step == 3"
                @click="step++"
                class="btn btn-primary">
                    <i class="las la-save"></i>
                    Continuar
                </button>
              </div>
        </div>
    </div>

</div>
<script>
    function app() {
        return {
            step: 1,
        }
    }
</script>
