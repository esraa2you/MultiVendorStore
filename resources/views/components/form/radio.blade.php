@props(['name', 'options', 'label', 'checked' => false])
<label for="">{{ $label }}</label>
@foreach ($options as $value => $text)
    <div class="form-check">
        <input class="form-check-input" type="radio" name="{{ $name }}"
            @if (old($name, $checked) == $value) checked @endif value={{ $value }}
            {{ $attributes->class(['form-check-input', 'is-invalid' => $errors->has($name)]) }}>
        <label class="form-check-label">
            {{ $text }}
        </label>
    </div>
@endforeach
{{--
<div class="form-check">
    <input class="form-check-input" type="radio" name="status"@if (old('status', $category->status) == 'archived') checked @endif
        value="archived">
    <label class="form-check-label">
        archived
    </label> --}}
