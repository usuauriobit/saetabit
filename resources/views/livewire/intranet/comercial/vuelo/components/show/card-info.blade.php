<div class="h-full" style="min-height: 90vh">
    {{-- <div class="absolute bottom-0 left-0 ...">
        <img class="object-fill w-full " src="{{asset('img/repo/bg-waves-airplane.png')}}" alt="">
    </div> --}}
    <div class="p-4 ">
        <div class="mb-2 text-xl font-semibold text-white">
            {{$vuelo->tipo_vuelo->desc_categoria}}
        </div>

        <div class="card-white">
            <div class="p-4">
                <span class="text-xs text-gray-400">
                    ID: {{$vuelo->id}}
                </span>
                <br>
                <span class="text-xs text-gray-400">
                    COD: {{$vuelo->vuelo_codigo}}
                </span>

                @include('livewire.intranet.comercial.vuelo.components.vuelo-status', ['vuelo' => $vuelo, 'wFull' => true])

            </div>

        <div class="px-4 py-2 my-3 bordered">
            <x-master.item label="Avión" :sublabel="optional($vuelo->avion)->matricula">
                <x-slot name="sublabel">
                    @if ($vuelo->avion)
                        {{optional($vuelo->avion)->matricula}}
                    @else
                        <div class="badge badge-error">
                            No seleccionado
                        </div>
                    @endif
                </x-slot>
                <x-slot name="avatar">
                    <i class="las la-plane"></i>
                </x-slot>
                <x-slot name="actions">
                    @if (!$vuelo->is_closed)
                        <button x-show="!toEditAvion" @click="toEditAvion = true" class="btn btn-sm btn-primary">
                            <i class="las la-edit"></i>
                        </button>
                        <button x-show="toEditAvion" @click="toEditAvion = false" class="btn btn-sm btn-danger">
                            <i class="las la-times"></i>
                        </button>
                    @endif
                </x-slot>
            </x-master.item>
            @if (!$vuelo->is_closed)
                <div x-show="toEditAvion">
                    <livewire:intranet.comercial.vuelo.components.input-avion />
                </div>
            @endif
        </div>
    </div>
        <x-item.vuelo :vuelo="$vuelo"/>
    </div>
</div>
