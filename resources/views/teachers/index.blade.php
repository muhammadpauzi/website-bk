@extends('layouts.app')

@section('content')
<div class="col">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <div class="dropdown me-2">
                <a class="btn btn-sm border p-2 dropdown-toggle dropdown-without-icon" href="#"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i data-feather="more-vertical"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li>
                        <h6 class="dropdown-header">Import Data Guru</h6>
                    </li>
                    <li>
                        <form action="{{ route('teachers.template') }}" method="post">
                            @csrf
                            <button class="dropdown-item" type="submit">
                                <i data-feather="download" class="me-2 icon-size"></i>
                                Download Template Excel
                            </button>
                        </form>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                            data-bs-target="#importTeacherExcelModal">
                            <i data-feather="upload" class="me-2 icon-size"></i>
                            Import Data Guru (.xlsx)</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i data-feather="file-text" class="me-2 icon-size"></i>
                            Download PDF Data Guru</a>
                    </li>
                </ul>
            </div>
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter"
                aria-controls="offcanvasFilter" type="button">
                <span data-feather="filter" class="icon-size"></span>
            </button>
        </div>
        <div>
            <a href="{{ route('teachers.create') }}" class="btn btn-primary fw-bold">
                <span data-feather="plus-circle" class="me-1 icon-size"></span>
                Tambah
            </a>
        </div>
    </div>

    @include('partials.validation-alerts')

    <div class="py-2">
        <x-forms.filters :sortItems="[
            'created_at' => 'Ditambahkan pada',
            'name' => 'Nama Lengkap',
            'nip' => 'NIP',
            'email' => 'Email',
        ]" />
    </div>

    <div class="card shadow-lg">
        <div class="card-header">
            Data Guru
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
                            <th scope="col">NIP</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Email</th>
                            <th scope="col">User</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Ditambahkan pada</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($teachers->isEmpty())
                        <tr class="no-whitespace">
                            <td colspan="8" class="text-center">
                                <span class="d-block text-danger fw-bold py-3">Data tidak ada!</span>
                            </td>
                        </tr>
                        @endif
                        @foreach ($teachers as $teacher)
                        <tr class="no-whitespace">
                            {{-- <th>
                                <div class="form-check d-flex align-items-center justify-content-center m-0">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                </div>
                            </th> --}}
                            <th scope="row" class="text-center">{{ ($teachers->currentpage()-1) * $teachers->perpage() +
                                $loop->index + 1
                                }}</th>
                            <td>{{ $teacher->nip }}
                            </td>
                            <td>{{ $teacher->name }}</td>
                            <td>
                                <a href="mailto:{{ $teacher->email }}">{{ $teacher->email }}</a>
                            </td>
                            <td>
                                @if ($teacher?->user)
                                <a href="{{ route('users.show', $teacher->user->id) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $teacher->user->name }}</a>
                                @endif
                            </td>
                            <td>
                                <div class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">
                                    {{ $teacher->gender === 'l' ? 'Laki-Laki' :
                                    "Perempuan"
                                    }}</div>
                            </td>
                            <td>
                                {{ $teacher->created_at->format('d F Y H:i') }}
                            </td>
                            <td>
                                <a href="{{ route('teachers.show', $teacher) }}"
                                    class="badge text-info-emphasis bg-info-subtle border border-info-subtle">detail</a>
                                <a href="{{ route('teachers.edit', $teacher) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">edit</a>
                                <form action="{{ route('teachers.destroy', $teacher) }}" class="d-inline-block"
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

            {{ $teachers->onEachSide(1)->links() }}
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="importTeacherExcelModal" tabindex="-1" aria-labelledby="importTeacherExcelModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('teachers.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="importTeacherExcelModalLabel">Import Data Guru</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <x-forms.label id="file">File Template Excel</x-forms.label>
                        <x-forms.input type="file" name="file" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger fw-bold" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary fw-bold">
                        <span data-feather="upload" class="me-2 icon-size"></span>
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection