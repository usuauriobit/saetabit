<div class="mt-4">
    <div class="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-8 px-2 lg:px-14">
        <div class="p-4 rounded-box"
            style="
            background: url('{{ asset('img/default/colorful8.jpg') }}');
            background-size: cover;
        ">
            <img class="mx-auto h-36" src="{{ asset('img/repo/plane-1.png') }}" alt="">
            <div class="my-4 text-center">
                <span class="text-2xl font-bold ">Registrar vuelo</span>
            </div>
            @foreach ($tipos_dont_support_massive->groupBy('categoria_vuelo.descripcion') as $categoria => $items)
                <div class="my-4 card-blur p-6 border-zinc-500">
                    <strong>{{ $categoria }}</strong>
                    <br>
                    @foreach ($items as $item)
                        <a class="w-full mb-2 btn btn-sm btn-ghost"
                            href="{{ route('intranet.programacion-vuelo.vuelo.create-simple', ['tipo_vuelo_id' => $item->id]) }}">
                            <div class="flex-1 flex px-2">
                                {{ $item->descripcion }}
                            </div>
                            <div class="flex-none">
                                <i class="la la-arrow-right"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endforeach
        </div>
        <div class="p-4 rounded-box"
            style="
            background: url('{{ asset('img/default/colorful9.jpg') }}');
            background-size: cover;
        ">
            <img class="mx-auto h-36" src="{{ asset('img/repo/plane-2.png') }}" alt="">
            <div class="my-4 text-center">
                <span class="text-2xl font-bold ">Programar vuelos</span>
            </div>
            <div class="my-4 card-blur p-6 border-zinc-500">
                @foreach ($tipos_supports_massive as $item)
                    <a class="w-full mb-2 btn btn-sm btn-ghost"
                        href="{{ route('intranet.programacion-vuelo.vuelo.create-massive', ['tipo_vuelo_id' => $item->id]) }}">
                        <div class="flex-1 flex px-2">
                            {{ $item->descripcion }}
                        </div>
                        <div class="flex-none">
                            <i class="la la-arrow-right"></i>
                        </div>
                    </a>
                @endforeach

            </div>
        </div>
        <div class="p-4 rounded-box"
            style="
            background: url('{{ asset('img/default/colorful6.jpg') }}');
            background-size: cover;
        ">
            <img class="mx-auto h-36" src="{{ asset('img/repo/plane-1.png') }}" alt="">
            <div class="my-4 text-center">
                <span class="text-2xl font-bold ">Otros</span>
                <div class="my-4 card-blur p-6 border-zinc-500">
                    <a class="w-full mb-2 btn btn-sm btn-ghost" href="#generarProforma">
                        <div class="flex-1 flex px-2">
                            Generar proforma
                        </div>
                        <div class="flex-none">
                            <i class="la la-arrow-right"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <x-master.modal id-modal="generarProforma" wire:ignore.self>
        <livewire:intranet.proforma-form />
    </x-master.modal>
</div>
