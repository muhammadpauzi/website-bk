@extends('layouts.app')

@section('content')
<div class="col-lg-7 col-md-6">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('teachers.index') }}" class="btn btn-sm btn-light border">
                <i data-feather="arrow-left" class="me-1 icon-size"></i>
                Kembali</a>
        </div>
        <div>

        </div>
    </div>
    <div class="card shadow-lg">
        <div class="card-header">
            Form {{ $title }}
        </div>
        <div class="card-body">
            <form action="{{ route('teachers.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <x-forms.label id="name">Nama Lengkap Guru</x-forms.label>
                    <x-forms.input name="name" />
                </div>
                <div class="mb-3">
                    <x-forms.label id="nip">NIP</x-forms.label>
                    <x-forms.input type="number" name="nip" min="000000000000000000" max="999999999999999999" />
                </div>
                <div class="mb-3">
                    <x-forms.label id="email">Email Guru</x-forms.label>
                    <x-forms.input type="email" name="email" />
                </div>

                <div class="mb-5">
                    <x-forms.label id="gender">Jenis Kelamin</x-forms.label>

                    <x-forms.radios name="gender" :items="['l' => 'Laki-Laki', 'p' => 'Perempuan']"
                        valueDefaultChecked="l" />

                </div>

                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <button type="reset" class="btn btn-warning fw-bold">
                            <i data-feather="refresh-ccw" class="me-1 icon-size"></i>
                            Clear</button>
                    </div>
                    <div>
                        <button class="btn btn-primary fw-bold">
                            <i data-feather="save" class="me-1 icon-size"></i>
                            Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection