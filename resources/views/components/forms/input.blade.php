@props(['id', 'name', 'value' => '', 'type' => 'text'])


<input type="{{ $type }}" {{ $attributes->merge(['class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')
]) }} id="{{ $id ?? $name }}"
name="{{ $name }}" value="{{ $value }}" {{ $attributes }} />

@error($name)
<div id="{{ $id ?? $name }}" class="invalid-feedback">
    {{ $message }}
</div>
@enderror