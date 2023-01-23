@extends('layouts.app')

@section('content')
<div class="col-lg-7 col-md-6">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('students.index') }}" class="btn btn-sm btn-light border">
                <i data-feather="arrow-left" class="me-1 icon-size"></i>
                Kembali</a>
        </div>
        <div>

        </div>
    </div>
    <div class="card shadow-lg">
        <form action="{{ route('students.store') }}" method="POST">
            @csrf
            <div class="card-header">
                Form {{ $title }}
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <x-forms.label id="name">Nama Lengkap Siswa</x-forms.label>
                    <x-forms.input name="name" />
                </div>
                <div class="mb-3">
                    <x-forms.label id="nis">NIS</x-forms.label>
                    <x-forms.input type="number" name="nis" min="0000000000" max="9999999999" />
                </div>
                <div class="mb-3">
                    <x-forms.label id="nisn">NISN</x-forms.label>
                    <x-forms.input type="number" name="nisn" min="0000000000" max="9999999999" />
                </div>
                <div class="mb-3">
                    <x-forms.label id="email">Email Siswa</x-forms.label>
                    <x-forms.input type="email" name="email" />
                </div>

                <div class="mb-3">
                    <x-forms.label id="gender">Jenis Kelamin</x-forms.label>

                    <x-forms.radios name="gender" :items="['l' => 'Laki-Laki', 'p' => 'Perempuan']"
                        valueDefaultChecked="l" />

                </div>

                <div class="mb-3">
                    <x-forms.label id="parent_id" :required="false">Orang Tua</x-forms.label>
                    <x-forms.tom-select id="parent_id" name="parent_id" placeholder="Pilih orang tua...">
                        @foreach ($parents as $parent)
                        <option @selected($parent->id == old('parent_id')) value="{{ $parent->id }}">#{{
                            $parent->id }} - {{
                            $parent->name }}</option>
                        @endforeach
                    </x-forms.tom-select>
                </div>
            </div>
            <div class="card-footer">
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
            </div>
        </form>
    </div>
</div>
@endsection