@props(['sortItems' => []])

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasFilter" aria-labelledby="offcanvasFilterLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasFilterLabel">Form Filter Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="">
            <div class="mb-3">
                <x-forms.label id="sorts" :required="false">Urut berdasarkan</x-forms.label>
                <select class="form-select" id="sort" name="sort">
                    @foreach ($sortItems as $key => $value)
                    <option @selected(request('sort')===$key . ',asc' ) value="{{ $key . ',asc' }}">{{ $value }} (ASC)
                    </option>
                    <option @selected(request('sort')===$key . ',desc' ) value="{{ $key . ',desc' }}">{{ $value }}
                        (DESC)
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <x-forms.label id="search" :required="false">Cari berdasarkan keyword</x-forms.label>
                <x-forms.input name="search" :value="request('search')" />
            </div>

            {{ $slot }}

            <button class="btn btn-outline-primary fw-bold w-100 d-block mt-2" type="submit">
                <span data-feather="search" class="me-1 icon-size"></span>
                Cari</button>
        </form>
    </div>
</div>