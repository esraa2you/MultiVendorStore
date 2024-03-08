{{-- @props(['label', 'name', 'options', 'selected'])
<label>{{ $label }}</label>
<select type="text" name="{{ $name }}}" class="form-control form-select">
    @foreach ($options as $option)
        <option value="{{ $option }}" @if (old($selected, $option) == $option) selected @endif>
            {{ $option }}</option>
    @endforeach
</select> --}}
@props(['name', 'selected' => '', 'label' => false, 'options'])

@if ($label)
    <label for="">{{ $label }}</label>
@endif

<select name="{{ $name }}"
    {{ $attributes->class(['form-control', 'form-select', 'is-invalid' => $errors->has($name)]) }}>
    @foreach ($options as $value => $text)
        <option value="{{ $value }}" @if ($value == $selected) selected @endif>{{ $text }}
        </option>
    @endforeach
</select>
