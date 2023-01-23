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
                        <h6 class="dropdown-header">Import Data Kelas</h6>
                    </li>
                    <li>
                        <form action="{{ route('classes.template') }}" method="post">
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
                            Import Data Kelas (.xlsx)</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i data-feather="file-text" class="me-2 icon-size"></i>
                            Download PDF Data Kelas</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                            data-bs-target="#pindahKelasSiswaModal">
                            <i data-feather="arrow-right" class="me-2 icon-size"></i>
                            Pindah Kelas</a>
                    </li>
                </ul>
            </div>

            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter"
                aria-controls="offcanvasFilter" type="button">
                <span data-feather="filter" class="icon-size"></span>
            </button>
        </div>
        <div>
            <a href="{{ route('classes.create') }}" class="btn btn-primary fw-bold">
                <span data-feather="plus-circle" class="me-1 icon-size"></span>
                Tambah
            </a>
        </div>
    </div>

    @include('partials.validation-alerts')

    <div class="py-2">
        <x-forms.filters :sortItems="[
            'created_at' => 'Ditambahkan pada',
            'name' => 'Nama Kelas'
        ]">
            <div class="mb-3">
                <x-forms.label id="by_wali_kelas" :required="false">Wali Kelas</x-forms.label>
                <x-forms.tom-select id="by_wali_kelas" name="by_wali_kelas" placeholder="Pilih wali kelas (guru)...">
                    @foreach ($teachers as $teacher)
                    <option @selected($teacher->id == request('by_wali_kelas')) value="{{ $teacher->id }}">{{
                        $teacher->nip }} - {{
                        $teacher->name }}</option>
                    @endforeach
                </x-forms.tom-select>
            </div>
        </x-forms.filters>
    </div>

    <div class="card shadow-lg">
        <div class="card-header">
            Data Kelas
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
                            <th scope="col">Nama Kelas</th>
                            <th scope="col">Wali Kelas</th>
                            <th scope="col">Siswa-Siswa</th>
                            <th scope="col">Ditambahkan pada</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($classes->isEmpty())
                        <tr class="no-whitespace">
                            <td colspan="8" class="text-center">
                                <span class="d-block text-danger fw-bold py-3">Data tidak ada!</span>
                            </td>
                        </tr>
                        @endif
                        @foreach ($classes as $class)
                        <tr class="no-whitespace">
                            {{-- <th>
                                <div class="form-check d-flex align-items-center justify-content-center m-0">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                </div>
                            </th> --}}
                            <th scope="row" class="text-center">{{ ($classes->currentpage()-1) * $classes->perpage() +
                                $loop->index + 1
                                }}</th>
                            <td>{{ $class->name }}</td>
                            <td>
                                <a href="{{ route('teachers.show', $class->waliKelas->id) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $class->waliKelas->name }}</a>
                            </td>
                            <td>
                                @foreach ($class->students as $student)
                                <a href="{{ route('students.show', $student->id) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $student->name }}</a>
                                @if ($loop->iteration % 4 === 0)
                                <br />
                                @endif
                                @endforeach
                            </td>
                            <td>
                                {{ $class->created_at->format('d F Y H:i') }}
                            </td>
                            <td>
                                <a href="{{ route('classes.show', $class) }}"
                                    class="badge text-info-emphasis bg-info-subtle border border-info-subtle">detail</a>
                                <a href="{{ route('classes.edit', $class) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">edit</a>
                                <form action="{{ route('classes.destroy', $class) }}" class="d-inline-block"
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

            {{ $classes->onEachSide(1)->links() }}
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="importTeacherExcelModal" tabindex="-1" aria-labelledby="importTeacherExcelModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('classes.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="importTeacherExcelModalLabel">Import Data Kelas</h1>
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


<!-- Modal -->
<div class="modal fade" id="pindahKelasSiswaModal" tabindex="-1" aria-labelledby="pindahKelasSiswaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('classes.pindah-kelas') }}" method="POST"
                onsubmit="return confirm('Apakah anda yakin ingin memindahkan siswa-siswa ke kelas yang dipilih?')">
                @csrf

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="importTeacherExcelModalLabel">Modal Pindah Kelas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center" role="alert">
                        <div>
                            <sup class="fw-bolder">*</sup> Data siswa akan dipindahkan sesuai dengan kelas yang dipilih
                            dibawah.
                        </div>
                    </div>
                    <div class="mb-3">
                        <x-forms.label id="dari_kelas_id">Dari Kelas</x-forms.label>
                        <x-forms.tom-select id="dari_kelas_id" name="dari_kelas_id" placeholder="Pilih kelas...">
                            @foreach ($allClasses as $class)
                            <option @selected($class->id == old('dari_kelas_id')) value="{{ $class->id }}">{{
                                $class->name }}</option>
                            @endforeach
                        </x-forms.tom-select>
                    </div>
                    <div class="mb-3">
                        <x-forms.label id="pindah_ke_kelas_id">Pindah ke Kelas</x-forms.label>
                        <x-forms.tom-select id="pindah_ke_kelas_id" name="pindah_ke_kelas_id"
                            placeholder="Pilih kelas...">
                            @foreach ($allClasses as $class)
                            <option @selected($class->id == old('pindah_ke_kelas_id')) value="{{ $class->id }}">{{
                                $class->name }}</option>
                            @endforeach
                        </x-forms.tom-select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger fw-bold" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary fw-bold">
                        <span data-feather="upload" class="me-2 icon-size"></span>
                        Pindah Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection