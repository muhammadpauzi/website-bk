@props(['id', 'required' => true])
<label for="{{ $id }}" class="form-label fw-bold">{{ $slot }} @if ($required)
    <sup class="text-danger">*</sup>
    @endif</label>