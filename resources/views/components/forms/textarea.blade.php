@props(['id', 'name',])

<textarea class="form-control @error($name) is-invalid @enderror" id="{{ $id ?? $name }}" name="{{ $name }}" {{
    $attributes }}>{{ $slot }}</textarea>

@error($name)
<div id="{{ $id ?? $name }}" class="invalid-feedback">
    {{ $message }}
</div>
@enderror