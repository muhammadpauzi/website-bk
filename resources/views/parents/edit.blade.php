@extends('layouts.app')

@section('content')
<div class="col-lg-7 col-md-6">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('parents.index') }}" class="btn btn-sm btn-light border">
                <i data-feather="arrow-left" class="me-1 icon-size"></i>
                Kembali</a>
        </div>
        <div>

        </div>
    </div>
    <div class="card shadow-lg">
        <form action="{{ route('parents.update', $parent) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-header">
                Form {{ $title }}
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <x-forms.label id="name">Nama Lengkap Orang Tua</x-forms.label>
                    <x-forms.input name="name" :value="old('name', $parent->name)" />
                </div>

                <div class="mb-3">
                    <x-forms.label id="alamat">Alamat</x-forms.label>
                    <x-forms.textarea name="alamat" maxlength="512">{{
                        old('alamat', $parent->alamat)
                        }}
                    </x-forms.textarea>
                </div>
                <div class="mb-3">
                    <x-forms.label id="phone">No. HP</x-forms.label>
                    <x-forms.input type="tel" name="phone" maxlength="20" :value="old('phone', $parent->phone)" />
                </div>

                <div class="mb-5">
                    <x-forms.label id="gender">Jenis Kelamin</x-forms.label>

                    <x-forms.radios name="gender" :items="['l' => 'Laki-Laki', 'p' => 'Perempuan']"
                        :valueDefaultChecked="old('gender', $parent->gender)" />

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