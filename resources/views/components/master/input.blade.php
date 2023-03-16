@props([
    'textarea' => false,
    'label' => null,
    'altLabelTR' => null,
    'altLabelBL' => null,
    'altLabelBL' => null,
    'altLabelBR' => null,
    'prefix' => null,
    'suffix' => null,
    'upperCase' => true,
])
<div class="w-full form-control" x-data="{
    handleOnChange(e) {
            if (!['number', 'date', 'datetime'].includes(e.target.type)) {
                e.target.value = this.quitarAcentos(e.target.value.toUpperCase())
            }
        },
        quitarAcentos(str) {
            const acentos = { 'Á': 'A', 'É': 'E', 'Í': 'I', 'Ó': 'O', 'Ú': 'U' };
            return str.split('').map(letra => acentos[letra] || letra).join('').toString();
        }
}">

    <label class="label">
        <span class="label-text">{{ $label }}</span>
        <span class="label-text-alt">{{ $altLabelTR ?? '' }}</span>
    </label>
    @if ($textarea)
        <textarea @if ($upperCase) x-on:keyup="handleOnChange" @endif
            {{ $attributes->merge(['class' => 'textarea textarea-bordered']) }}></textarea>
    @else
        <label class="{{ $prefix || $suffix ? 'input-group' : '' }}">
            @if ($prefix)
                <span>{{ $prefix }}</span>
            @endif
            <input @if ($upperCase) x-on:keyup="handleOnChange" @endif
                {{ $attributes->merge(['class' => 'w-full  input input-bordered']) }} type="text" />
            {{ $suffix }}
        </label>
    @endif
    @if (isset($altLabelBL) || isset($altLabelBR))
        <label class="label">
            <span class="label-text-alt">{{ $altLabelBL ?? '' }}</span>
            <span class="label-text-alt">{{ $altLabelBR ?? '' }}</span>
        </label>
    @endif
    @if ($errors->has($attributes['name']))
        <label class="label">
            <span class="text-error">{{ $errors->first($attributes['name']) }}</span>
        </label>
    @endif

</div>
