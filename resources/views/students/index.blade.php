@extends('layouts.app')

@section('content')
<div class="col">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <div class="dropdown">
                <a class="btn btn-sm border p-2 dropdown-toggle dropdown-without-icon" href="#"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i data-feather="more-vertical"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li>
                        <h6 class="dropdown-header">Import Data Siswa</h6>
                    </li>
                    <li>
                        <form action="{{ route('students.template') }}" method="post">
                            @csrf
                            <button class="dropdown-item" type="submit">
                                <i data-feather="download" class="me-2 icon-size"></i>
                                Download Template Excel
                            </button>
                        </form>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                            data-bs-target="#importStudentExcelModal">
                            <i data-feather="upload" class="me-2 icon-size"></i>
                            Import Data Siswa (.xlsx)</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i data-feather="file-text" class="me-2 icon-size"></i>
                            Download PDF Data Siswa</a>
                    </li>
                </ul>
            </div>
        </div>
        <div>
            <a href="{{ route('students.create') }}" class="btn btn-primary fw-bold">
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
            'nis' => 'NIS',
            'nisn' => 'NISN',
            'email' => 'Email',
        ]" />
    </div>

    <div class="card shadow-lg">
        <div class="card-header">
            Data Siswa
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
                            <th scope="col">NIS / NISN</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Email</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Ditambahkan pada</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($students->isEmpty())
                        <tr class="no-whitespace">
                            <td colspan="8" class="text-center">
                                <span class="d-block text-danger fw-bold py-3">Data tidak ada!</span>
                            </td>
                        </tr>
                        @endif
                        @foreach ($students as $student)
                        <tr class="no-whitespace">
                            {{-- <th>
                                <div class="form-check d-flex align-items-center justify-content-center m-0">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                </div>
                            </th> --}}
                            <th scope="row" class="text-center">{{ ($students->currentpage()-1) * $students->perpage() +
                                $loop->index + 1
                                }}</th>
                            <td>{{ $student->nis }} <span style="font-weight: 900;">/</span> {{
                                $student->nisn }}
                            </td>
                            <td>{{ $student->name }}</td>
                            <td>
                                <a href="mailto:{{ $student->email }}">{{ $student->email }}</a>
                            </td>
                            <td>
                                <div class="badge text-bg-primary">{{ $student->gender === 'l' ? 'Laki-Laki' :
                                    "Perempuan"
                                    }}</div>
                            </td>
                            <td>
                                {{ $student->created_at->format('d F Y H:i') }}
                            </td>
                            <td>
                                <a href="{{ route('students.show', $student) }}" class="badge text-bg-info">detail</a>
                                <a href="{{ route('students.edit', $student) }}" class="badge text-bg-primary">edit</a>
                                <form action="{{ route('students.destroy', $student) }}" class="d-inline-block"
                                    onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border-0 badge text-bg-danger fw-bold">hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr>

            {{ $students->onEachSide(1)->links() }}
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="importStudentExcelModal" tabindex="-1" aria-labelledby="importStudentExcelModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="importStudentExcelModalLabel">Import Data Siswa</h1>
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