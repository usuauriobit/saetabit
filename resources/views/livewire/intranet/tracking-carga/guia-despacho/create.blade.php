<div>

    @include('components.alert-errors')
    <div class="card-white ">

        <div class="card-body">
            <h4 class="text-lg font-semibold">Registro de guía de despacho</h4>
            <form wire:submit.prevent="save">
                <div x-data="app()" class="grid items-center grid-cols-1 gap-4 lg:grid-cols-3">
                    <div>
                        <img src="{{ asset('img/gif/box1.gif') }}" alt="">
                    </div>
                    <div class="lg:col-span-2">
                        <div wire:loading class="w-full">
                            <div class="loader">Cargando...</div>
                        </div>
                        <div wire:loading.remove>
                            <div class="w-full my-2">
                                <ul class="steps steps-horizontal">
                                    <li class="step" :class="{ 'step-primary': $wire.step >= 1 }">Personas</li>
                                    <li class="step" :class="{ 'step-primary': $wire.step >= 2 }">Ubicaciones</li>
                                    <li class="step" :class="{ 'step-primary': $wire.step == 3 }">Extra</li>
                                </ul>
                            </div>
                            <div>
                                <div x-transition:enter.duration.500ms x-show="$wire.step == 1">
                                    @include('livewire.intranet.tracking-carga.guia-despacho.components.step_1')
                                </div>
                                <div x-transition:enter.duration.500ms x-show="$wire.step == 2">
                                    @include('livewire.intranet.tracking-carga.guia-despacho.components.step_2')
                                </div>
                                <div x-transition:enter.duration.500ms x-show="$wire.step == 3">
                                    @include('livewire.intranet.tracking-carga.guia-despacho.components.step_3')
                                </div>
                            </div>
                            <div class="modal-action">
                                <button x-transition:enter.duration.500ms x-show="$wire.step>1" @click="$wire.backStep"
                                    type="button" wire:loading.attr="disabled" class="btn btn-primary btn-outline">
                                    <i class="la la-arrow-left"></i> Atrás
                                </button>
                                <button x-transition:enter.duration.500ms x-show="$wire.step<3" @click="$wire.nextStep"
                                    type="button" wire:loading.attr="disabled" class="btn btn-primary">
                                    Siguiente
                                    <i class="la la-arrow-right"></i>
                                </button>
                                <button x-transition:enter.duration.500ms x-show="$wire.step==3"
                                    type="submit" wire:loading.attr="disabled" class="btn btn-primary">
                                    <i class="la la-save"></i> Guardar
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function app() {
        // return {
        //     step: 1
        // }
    }
</script>
