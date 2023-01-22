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
                        <h6 class="dropdown-header">Bulk Aksi</h6>
                    </li>
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
        </div>
        <div>
            <a href="" class="btn btn-primary">
                <i data-feather="plus-circle" class="text-sm me-1"></i>
                Tambah
            </a>
        </div>
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
                            <th scope="col">
                                <div class="form-check d-flex align-items-center justify-content-center m-0">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                </div>
                            </th>
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
                            <th>
                                <div class="form-check d-flex align-items-center justify-content-center m-0">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                </div>
                            </th>
                            <th scope="row">{{ ($students->currentpage()-1) * $students->perpage() + $loop->index + 1
                                }}</th>
                            <td>{{ $student->nis }} <span class="fw-light text-muted">/</span> {{
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
                                <a href="" class="badge text-bg-primary">edit</a>
                                <a href="" class="badge text-bg-danger fw-bold">hapus</a>
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
@endsection