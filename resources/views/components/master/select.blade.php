<div class="form-control">
    <label class="label">
        <span class="label-text">{{ $label }}</span>
        @if (!is_null($helperTop))
            <div class="label-text-alt">
                {{ $helperTop }}
            </div>
        @endif
    </label>
    <select
        class="w-full
        select
        {{ $bordered ? 'select-bordered' : '' }}
        {{ $ghost ? 'select-ghost' : '' }}
        {{ $brandColorPrimary ? 'select-primary' : '' }}
        {{ $brandColorSecondary ? 'select-secondary ' : '' }}
        {{ $brandColorAccent ? 'select-accent ' : '' }}
        {{ $sizeLg ? 'select-lg' : '' }}
        {{ $sizeSm ? 'select-sm' : '' }}
        {{ $sizeXs ? 'select-xs' : '' }}
        {{ $errors->has($name) ? 'select-error' : '' }}
    "
        name="{{ $name ?? '' }}" {{ $attributes }}>
        <option value="">Seleccionar una opción</option>

        @foreach ($options as $element)
            @php
                $a = old($name, $val ?? '');
            @endphp
            <option {{ $a == $element[$val ?? 'id'] ? 'selected' : '' }} value="{{ $element[$val] }}">
                {{ $element[$desc] }} </option>
        @endforeach
    </select>
    @if ($errors->has($name))
        <label class="label">
            <span class="text-red-500 label-text-alt">{{ $errors->first($name) }}</span>
        </label>
    @endif
    @if (!is_null($altLabelBL))
        <label class="label">
            {{ $altLabelBL }}
            </lab>
    @endif
</div>
