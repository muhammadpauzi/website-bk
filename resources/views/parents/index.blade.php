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
                        <h6 class="dropdown-header">Import Data Orang Tua</h6>
                    </li>
                    <li>
                        <form action="{{ route('parents.template') }}" method="post">
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
                            Import Data Orang Tua (.xlsx)</a>
                    </li>
                </ul>
            </div>

            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter"
                aria-controls="offcanvasFilter" type="button">
                <span data-feather="filter" class="icon-size"></span>
            </button>
        </div>
        <div>
            <a href="{{ route('parents.create') }}" class="btn btn-primary fw-bold">
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
            'phone' => 'No. HP',
        ]" />
    </div>

    <div class="card shadow-lg">
        <div class="card-header">
            Data Orang Tua
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
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Siswa / Anak</th>
                            <th scope="col">User</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">No. HP</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Ditambahkan pada</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($parents->isEmpty())
                        <tr class="no-whitespace">
                            <td colspan="8" class="text-center">
                                <span class="d-block text-danger fw-bold py-3">Data tidak ada!</span>
                            </td>
                        </tr>
                        @endif
                        @foreach ($parents as $parent)
                        <tr class="no-whitespace">
                            <th scope="row" class="text-center">{{ ($parents->currentpage()-1) *
                                $parents->perpage() +
                                $loop->index + 1
                                }}</th>
                            <td>{{ $parent->name }}</td>
                            <td>
                                @if ($parent?->students)
                                @foreach ($parent->students as $student)
                                <a href="{{ route('students.show', $student->id) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $student->name }}</a>
                                @if ($loop->iteration % 4 === 0)
                                <br />
                                @endif
                                @endforeach
                                @endif
                            </td>
                            <td>
                                @if ($parent?->user)
                                <a href="{{ route('users.show', $parent->user->id) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $parent->user->name }}</a>
                                @endif
                            </td>
                            <td>{!! nl2br($parent->alamat) !!}</td>
                            <td>{{ $parent->phone }}</td>
                            <td>
                                <div class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">
                                    {{ $parent->gender === 'l' ? 'Laki-Laki' :
                                    "Perempuan"
                                    }}</div>
                            </td>
                            <td>
                                {{ $parent->created_at->format('d F Y H:i') }}
                            </td>
                            <td>
                                <a href="{{ route('parents.show', $parent) }}"
                                    class="badge text-info-emphasis bg-info-subtle border border-info-subtle">detail</a>
                                <a href="{{ route('parents.edit', $parent) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">edit</a>
                                <form action="{{ route('parents.destroy', $parent) }}" class="d-inline-block"
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

            {{ $parents->onEachSide(1)->links() }}
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="importStudentExcelModal" tabindex="-1" aria-labelledby="importStudentExcelModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('parents.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="importStudentExcelModalLabel">Import Data Orang Tua</h1>
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