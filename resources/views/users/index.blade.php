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
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                            data-bs-target="#synchronizeAccountModal">
                            <span data-feather="refresh-cw" class="me-2 icon-size"></span>
                            Synchronize Akun</a>
                    </li>
                </ul>
            </div>
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter"
                aria-controls="offcanvasFilter" type="button">
                <span data-feather="filter" class="icon-size"></span>
            </button>
        </div>
        <div>
            <a href="{{ route('users.create') }}" class="btn btn-primary fw-bold">
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
            'email' => 'Email',
            'role' => 'Role / Hak Akses',
        ]" />
    </div>

    <div class="card shadow-lg">
        <div class="card-header">
            Data Users
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
                            <th scope="col">Email / Username</th>
                            <th scope="col">Role</th>
                            <th scope="col">Ditambahkan pada</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->isEmpty())
                        <tr class="no-whitespace">
                            <td colspan="8" class="text-center">
                                <span class="d-block text-danger fw-bold py-3">Data tidak ada!</span>
                            </td>
                        </tr>
                        @endif
                        @foreach ($users as $user)
                        <tr class="no-whitespace">
                            {{-- <th>
                                <div class="form-check d-flex align-items-center justify-content-center m-0">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                </div>
                            </th> --}}
                            <th scope="row" class="text-center">{{ ($users->currentpage()-1) * $users->perpage() +
                                $loop->index + 1
                                }}</th>
                            <td>{{ $user->name }}</td>
                            <td>
                                @if ($user->role === \App\Models\User::$SUPERADMIN)
                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                @else
                                {{ $user->username }}
                                @endif
                            </td>
                            <td>
                                @if ($user->role === \App\Models\User::$SUPERADMIN)
                                <div class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">
                                    SUPERADMIN</div>
                                @elseif($user->role === \App\Models\User::$TEACHER)
                                <div class="badge text-info-emphasis bg-info-subtle border border-info-subtle">
                                    GURU |
                                    @if(optional($user->teacher))
                                    <a href="{{ route('teachers.show', optional($user->teacher)->name) }}">{{
                                        $user->name }}</a>
                                    @endif
                                </div>
                                @elseif($user->role === \App\Models\User::$STUDENT)
                                <div class="badge text-success-emphasis bg-success-subtle border border-success-subtle">
                                    SISWA |
                                    @if(optional($user->student))
                                    <a href="{{ route('students.show', optional($user->student)->name) }}">{{
                                        $user->name }}</a>
                                    @endif
                                </div>
                                @elseif($user->role === \App\Models\User::$PARENT)
                                <div class="badge text-warning-emphasis bg-warning-subtle border border-warning-subtle">
                                    ORANG TUA |
                                    @if(optional($user->parent))
                                    <a href="{{ route('parents.show', optional($user->parent)->name) }}">{{
                                        $user->name }}</a>
                                    @endif
                                </div>
                                @endif
                            </td>
                            <td>
                                {{ $user->created_at->format('d F Y H:i') }}
                            </td>
                            <td>
                                <a href="{{ route('users.show', $user) }}"
                                    class="badge text-info-emphasis bg-info-subtle border border-info-subtle">detail</a>
                                <a href="{{ route('users.edit', $user) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">edit</a>
                                <form action="{{ route('users.destroy', $user) }}" class="d-inline-block"
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

            {{ $users->onEachSide(1)->links() }}
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="synchronizeAccountModal" tabindex="-1" aria-labelledby="synchronizeAccountModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('users.synchronize') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="synchronizeAccountModalLabel">Synchronize Akun</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">

                        <ul>
                            <li>Generate, Akan mengenerate data users dari sebuah data (guru, siswa, orang tua) yang
                                dipilih yang digunakan untuk
                                login. (* proses ini mungkin relatif lama, jika datanya banyak)</li>
                            <li>Sync, Akan mengupdate data seperti nama, agar sama dengan data relasi (guru, siswa,
                                orang tua) nya.</li>
                            <li>Jika data guru, siswa, dan orang tua dihapus, maka data users juga akan terhapus.</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <x-forms.label id="method">Metode</x-forms.label>
                        <select class="form-select" id="method" name="method">
                            <option value="generate_teachers">Generate: Akun Guru</option>
                            <option value="generate_students">Generate: Akun Siswa</option>
                            <option value="generate_parents">Generate: Akun Orang Tua</option>
                            <option value="sync_teachers">Sync: Akun Guru</option>
                            <option value="sync_students">Sync: Akun Siswa</option>
                            <option value="sync_parents">Sync: Akun Orang Tua</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <x-forms.label id="password" :required="false">Password</x-forms.label>
                        <x-forms.input type="password" name="password" />
                        <small class="text-muted">Wajib di-isi jika menggunakan metode "Generate".</small>
                    </div>

                    <div class="mb-3">
                        <x-forms.label id="password_confirmation" :required="false">Ulangi Password</x-forms.label>
                        <x-forms.input type="password" name="password_confirmation" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger fw-bold" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary fw-bold">
                        <span data-feather="refresh-cw" class="me-2 icon-size"></span>
                        Synchronize
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection