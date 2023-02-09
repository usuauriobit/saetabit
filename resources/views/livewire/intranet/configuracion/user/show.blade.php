<x-master.modal id-modal="showOficinaModal">
    <div wire:loading class="w-full">
        <div class="loader">Cargando...</div>
    </div>
    <div wire:loading.remove>
        @if(is_null($user))
            <div class="loader">Cargando...</div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div>
                    <div class="avatar">
                        <div class="mb-2 w-52 h-52 rounded-btn">
                            <img src="{{$user->profile_photo_url}}">
                        </div>
                    </div>

                </div>
                <div>
                    <x-master.item class="mb-4" label="Nombre" :sublabel="$user->name"></x-master.item>
                    <x-master.item class="mb-4" label="Oficina" :sublabel="optional(optional($user->personal)->oficina)->descripcion"></x-master.item>
                    <x-master.item class="mb-4" label="Email" :sublabel="$user->email"></x-master.item>
                    <x-master.item label="Roles">
                        <x-slot name="sublabel">
                            @foreach ($user->roles as $rol)
                                <div class="badge badge-info">{{ $rol->name }}</div>
                            @endforeach
                        </x-slot>
                    </x-master.item>
                </div>
            </div>
        @endif
    </div>
    <div class="modal-action">
        <a href="#" class="btn btn-ghost">Cerrar</a>
    </div>

</x-master.modal>
