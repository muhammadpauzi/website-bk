@props(['sortItems' => []])

<form action="">
    <div class="input-group mb-3">
        <select class="form-select" id="sort" name="sort">
            @foreach ($sortItems as $key => $value)
            <option @selected(request('sort')===$key . ',asc' ) value="{{ $key . ',asc' }}">{{ $value }} (ASC)
            </option>
            <option @selected(request('sort')===$key . ',desc' ) value="{{ $key . ',desc' }}">{{ $value }} (DESC)
            </option>
            @endforeach
        </select>
        <input type="text" class="form-control" name="search" placeholder="Masukan keyword disini..."
            value="{{ request('search') }}" />
        <button class="btn btn-outline-primary fw-bold" type="submit">
            <span data-feather="search" class="me-1 icon-size"></span>
            Cari</button>
    </div>
</form>