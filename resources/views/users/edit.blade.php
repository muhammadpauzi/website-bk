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
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-header">
                Form {{ $title }}
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <x-forms.label id="name">Nama Lengkap</x-forms.label>
                    <x-forms.input name="name" :value="old('name', $user->name)" />
                </div>
                @if ($user->role === \App\Models\User::$SUPERADMIN)
                <div class="mb-3">
                    <x-forms.label id="email">Email</x-forms.label>
                    <x-forms.input type="email" name="email" :value="old('email', $user->email)" />
                </div>
                @else
                <div class="mb-3">
                    <x-forms.label id="username">Username</x-forms.label>
                    <x-forms.input type="text" name="username" :value="old('username', $user->username)" />
                </div>
                @endif
                <div class="mb-3">
                    <x-forms.label id="password">Password</x-forms.label>
                    <x-forms.input type="password" name="password" />
                    <small class="text-muted">Jika password di-isi, maka akan menggantikan password yang lama.</small>
                </div>
                <div class="mb-3">
                    <x-forms.label id="password_confirmation">Ulangi Password</x-forms.label>
                    <x-forms.input type="password" name="password_confirmation" />
                </div>

            </div>
            <div class="card-footer">
                <div class="d-flex align-items-center justify-content-end">
                    <div>
                        <button class="btn btn-primary fw-bold">
                            <i data-feather="save" class="me-1 icon-size"></i>
                            Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection