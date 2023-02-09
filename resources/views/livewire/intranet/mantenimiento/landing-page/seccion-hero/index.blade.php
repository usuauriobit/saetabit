<div>
    <div class="p-6">
        <x-master.item class="mb-4" label="Sección Hero del landing page"
            sublabel="Visualización de las secciones activas">
            <x-slot name="avatar">
                <i class="la la-list"></i>
            </x-slot>
            <x-slot name="actions">
                @can('intranet.mantenimiento.seccion-hero.create')
                    <a href="{{ route('intranet.mantenimiento.landing-page.seccion-hero.create') }}"
                        class="btn btn-primary">Registrar nuevo</a>
                @endcan
            </x-slot>
        </x-master.item>
        @forelse ($heroes as $hero)
            {{-- {{ dd($hero->url_img) }} --}}
            <div class="card-white mb-3">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <span>
                            Banner {{ $loop->iteration }}
                        </span>
                        @can('intranet.mantenimiento.landing-page.seccion-hero.delete')
                            <button wire:click="delete({{ $hero->id }})" class="btn btn-outline btn-danger">
                                Eliminar
                            </button>
                        @endcan
                    </div>
                </div>
                @include('components.landing-page.hero-item', ['hero' => $hero])
            </div>
        @empty
            <div class="card-white">
                <div class="card-body py-6 px-4 text-center">
                    <strong>No existen secciones</strong>
                    <p>
                        Se mostrará la sección por defecto en el landing page
                    </p>
                </div>
            </div>
            @include('components.landing-page.hero-item', ['hero' => null])
        @endforelse

    </div>

</div>
