@extends('layouts.app')

@section('content')
<div class="col">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter"
                aria-controls="offcanvasFilter" type="button">
                <span data-feather="filter" class="icon-size"></span>
            </button>
        </div>
        <div>
            <a href="{{ route('tindakans.create') }}" class="btn btn-primary fw-bold">
                <span data-feather="plus-circle" class="me-1 icon-size"></span>
                Tambah
            </a>
        </div>
    </div>

    @include('partials.validation-alerts')

    <div class="py-2">
        <x-forms.filters :sortItems="[
            'created_at' => 'Ditambahkan pada',
            'name' => 'Nama Tindakan',
            'min_point' => 'Min. Poin',
            'max_point' => 'Max. Poin',
        ]" />
    </div>

    <div class="card shadow-lg">
        <div class="card-header">
            Data Tindakan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="no-whitespace">
                            {{-- <th scope="col">
                                <div class="form-check d-flex align-items-center justify-content-center m-0">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                </div>
                            </th> --}}
                            <th scope="col" class="text-center">#</th>
                            <th scope="col">Nama Tindakan</th>
                            <th scope="col">Min. Poin</th>
                            <th scope="col">Max. Poin</th>
                            <th scope="col">Status Aktif</th>
                            <th scope="col">Ditambahkan pada</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($tindakans->isEmpty())
                        <tr class="no-whitespace">
                            <td colspan="8" class="text-center">
                                <span class="d-block text-danger fw-bold py-3">Data tidak ada!</span>
                            </td>
                        </tr>
                        @endif
                        @foreach ($tindakans as $tindakan)
                        <tr class="no-whitespace">
                            {{-- <th>
                                <div class="form-check d-flex align-items-center justify-content-center m-0">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                </div>
                            </th> --}}
                            <th scope="row" class="text-center">{{ ($tindakans->currentpage()-1) * $tindakans->perpage()
                                +
                                $loop->index + 1
                                }}</th>
                            <td>{{ $tindakan->name }}</td>
                            <td>
                                <span
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $tindakan->min_point }}</span>
                            </td>
                            <td>
                                <span
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $tindakan->max_point }}</span>
                            </td>
                            <td>
                                @if ($tindakan->is_active)
                                <div class="badge text-success-emphasis bg-success-subtle border border-success-subtle">
                                    Aktif</div>
                                @else
                                <div class="badge text-danger-emphasis bg-danger-subtle border border-danger-subtle">
                                    Nonaktif</div>
                                @endif
                            </td>
                            <td>
                                {{ $tindakan->created_at->format('d F Y H:i') }}
                            </td>
                            <td>
                                <a href="{{ route('tindakans.show', $tindakan) }}"
                                    class="badge text-info-emphasis bg-info-subtle border border-info-subtle">detail</a>
                                <a href="{{ route('tindakans.edit', $tindakan) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">edit</a>
                                <form action="{{ route('tindakans.destroy', $tindakan) }}" class="d-inline-block"
                                    onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="border-0 badge text-danger-emphasis bg-danger-subtle border border-danger-subtle fw-bold">hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr>

            {{ $tindakans->onEachSide(1)->links() }}
        </div>
    </div>
</div>
@endsection