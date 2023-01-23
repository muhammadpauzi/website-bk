@extends('layouts.app')

@section('content')
<div class="col-lg-7 col-md-6">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('offense-categories.index') }}" class="btn btn-sm btn-light border">
                <i data-feather="arrow-left" class="me-1 icon-size"></i>
                Kembali</a>
        </div>
        <div>

        </div>
    </div>
    <div class="card shadow-lg">
        <form action="{{ route('offense-categories.update', $offenseCategory) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-header">
                Form {{ $title }}
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <x-forms.label id="name">Nama Kategori</x-forms.label>
                    <x-forms.input name="name" :value="old('name', $offenseCategory->name)" />
                </div>

                <div class="mb-3">
                    <x-forms.label id="description" :required="false">Keterangan</x-forms.label>
                    <x-forms.textarea name="description">{{ old('description', $offenseCategory->description) }}
                    </x-forms.textarea>
                </div>

                <div class="mb-3">
                    <x-forms.label id="point">Point</x-forms.label>
                    <x-forms.input type="number" name="point" min="0" :value="old('point', $offenseCategory->point)" />
                </div>

                <div class="mb-5">
                    <x-forms.label id="is_active">Status Aktif</x-forms.label>

                    <x-forms.radios name="is_active" :items="['0' => 'Nonaktif', '1' => 'Aktif']"
                        :valueDefaultChecked="old('is_active', $offenseCategory->is_active)" />

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