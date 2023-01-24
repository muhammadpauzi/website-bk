@extends('layouts.app')

@section('content')
<div class="col-lg-7 col-md-6">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-light border">
                <i data-feather="arrow-left" class="me-1 icon-size"></i>
                Kembali</a>
        </div>
        <div>

        </div>
    </div>

    <div class="card shadow-lg">
        <div class="card-header">
            {{ $title }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-bg-light fw-bold">ID</td>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Nama Lengkap</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        @if ($user->role === \App\Models\User::$SUPERADMIN)
                        <tr>
                            <td class="text-bg-light fw-bold">Email</td>
                            <td>
                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td class="text-bg-light fw-bold">Username</td>
                            <td>
                                {{ $user->username }}
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-bg-light fw-bold">Role</td>
                            <td>
                                @if ($user->role === \App\Models\User::$SUPERADMIN)
                                <div class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">
                                    SUPERADMIN</div>
                                @elseif($user->role === \App\Models\User::$TEACHER)
                                <div class="badge text-info-emphasis bg-info-subtle border border-info-subtle">
                                    GURU |
                                    @if(optional($user->teacher))
                                    <a href="{{ route('teachers.show', optional($user->teacher)->id) }}">{{
                                        $user->name }}</a>
                                    @endif
                                </div>
                                @elseif($user->role === \App\Models\User::$STUDENT)
                                <div class="badge text-success-emphasis bg-success-subtle border border-success-subtle">
                                    SISWA |
                                    @if(optional($user->student))
                                    <a href="{{ route('students.show', optional($user->student)->id) }}">{{
                                        $user->name }}</a>
                                    @endif
                                </div>
                                @elseif($user->role === \App\Models\User::$PARENT)
                                <div class="badge text-warning-emphasis bg-warning-subtle border border-warning-subtle">
                                    ORANG TUA |
                                    @if(optional($user->parent))
                                    <a href="{{ route('parents.show', optional($user->parent)->id) }}">{{
                                        $user->name }}</a>
                                    @endif
                                </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Ditambahkan pada</td>
                            <td>{{ $user->created_at->format('d F Y H:i') }} ({{
                                $user->created_at->diffForHumans() }})</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Diubah pada</td>
                            <td>{{ $user->updated_at->format('d F Y H:i') }} ({{
                                $user->updated_at->diffForHumans() }})</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Aksi</td>
                            <td>
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
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection