<div class="p-6">
    <x-master.item class="mb-4" label="Registrar sección">
        <x-slot name="avatar">
            <i class="la la-list"></i>
        </x-slot>
        <x-slot name="actions">
            <button wire:click="save" class="btn btn-primary">
                <i class="la la-save"></i> &nbsp; Guardar
            </button>
        </x-slot>
    </x-master.item>
    <div class="card-white">
        <div class="card-body">
            <x-master.input :upperCase="false" wire:model.debounce.500ms="form.title" name="form.title" label="Título">
            </x-master.input>
            <x-master.input :upperCase="false" wire:model.debounce.500ms="form.subtitle" name="form.subtitle"
                label="Subtítulo">
            </x-master.input>
            <div class="grid grid-cols-2 my-4">
                <div class="border-4 border-indigo-500/50 p-4">
                    <strong>Imagen de fondo</strong>
                    <br>
                    @if ($photoBg)
                        <img src="{{ $photoBg->temporaryUrl() }}">
                    @endif

                    <input accept=".jpg, .jpeg, .png" type="file" wire:model="photoBg">

                    @error('photoBg')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="border-4 border-indigo-500/50 p-4">
                    <strong>Imagen principal</strong>
                    <br>
                    @if ($photoImg)
                        <img src="{{ $photoImg->temporaryUrl() }}">
                    @endif

                    <input accept=".jpg, .jpeg, .png" type="file" wire:model="photoImg">

                    @error('photoImg')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    {{-- @include('components.landing-page.hero-item', [
        'hero' => array_merge($this->preview_data, [
            'photoBg' => optional($photoBg ?? null)->temporaryUrl() ?? null,
            'photoImg' => optional($photoImg ?? null)->temporaryUrl() ?? null,
        ]),
    ]) --}}
    @include('components.landing-page.hero-item', [
        'hero' => $this->preview_data,
    ])

</div>
