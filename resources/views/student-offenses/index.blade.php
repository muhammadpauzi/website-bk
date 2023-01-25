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
            <a href="{{ route('student-offenses.create') }}" class="btn btn-primary fw-bold">
                <span data-feather="plus-circle" class="me-1 icon-size"></span>
                Tambah (Laporkan)
            </a>
        </div>
    </div>

    @include('partials.validation-alerts')

    <div class="py-2">
        <x-forms.filters :sortItems="[
            'created_at' => 'Ditambahkan pada',
            'reported_at' => 'Dilaporakan pada',
        ]" />
    </div>

    <div class="card shadow-lg">
        <div class="card-header">
            Data Pelanggaran Siswa
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
                            <th scope="col">Siswa</th>
                            <th scope="col">Dilaporkan oleh (Guru)</th>
                            <th scope="col">Kategori Pelanggaran (Poin)</th>
                            <th scope="col">Dilaporkan pada</th>
                            <th scope="col">Ditambahkan pada</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($studentOffenses->isEmpty())
                        <tr class="no-whitespace">
                            <td colspan="8" class="text-center">
                                <span class="d-block text-danger fw-bold py-3">Data tidak ada!</span>
                            </td>
                        </tr>
                        @endif
                        @foreach ($studentOffenses as $studentOffense)
                        <tr class="no-whitespace">
                            {{-- <th>
                                <div class="form-check d-flex align-items-center justify-content-center m-0">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                </div>
                            </th> --}}
                            <th scope="row" class="text-center">{{ ($studentOffenses->currentpage()-1) *
                                $studentOffenses->perpage() +
                                $loop->index + 1
                                }}</th>
                            <td>
                                <a href="{{ route('students.show', $studentOffense->student->id) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $studentOffense->student->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route('teachers.show', $studentOffense->reporter->id) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $studentOffense->reporter->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route('offense-categories.show', $studentOffense->offenseCategory->id) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $studentOffense->offenseCategory->name }} <span class="fw-bold">({{
                                        $studentOffense->offenseCategory->point }})</span></a>
                            </td>
                            <td>
                                {{ $studentOffense->reported_at->format('d F Y') }}
                            </td>
                            <td>
                                {{ $studentOffense->created_at->format('d F Y H:i') }}
                            </td>
                            <td>
                                <a href="{{ route('student-offenses.show', $studentOffense) }}"
                                    class="badge text-info-emphasis bg-info-subtle border border-info-subtle">detail</a>
                                <a href="{{ route('student-offenses.edit', $studentOffense) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">edit</a>
                                <form action="{{ route('student-offenses.destroy', $studentOffense) }}"
                                    class="d-inline-block"
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

            {{ $studentOffenses->onEachSide(1)->links() }}
        </div>
    </div>
</div>
@endsection