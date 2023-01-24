@extends('layouts.app')

@section('content')
<div class="col-lg-7 col-md-6">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('tindakans.index') }}" class="btn btn-sm btn-light border">
                <i data-feather="arrow-left" class="me-1 icon-size"></i>
                Kembali</a>
        </div>
        <div>

        </div>
    </div>
    <div class="card shadow-lg">
        <form action="{{ route('tindakans.store') }}" method="POST">
            @csrf
            <div class="card-header">
                Form {{ $title }}
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <x-forms.label id="name">Nama Tindakan</x-forms.label>
                    <x-forms.input name="name" />
                </div>

                <div class="mb-3">
                    <x-forms.label id="description" :required="false">Keterangan</x-forms.label>
                    <x-forms.textarea name="description"></x-forms.textarea>
                </div>

                <div class="mb-3">
                    <x-forms.label id="min_point">Min. Poin</x-forms.label>
                    <x-forms.input type="number" name="min_point" min="0" />
                </div>

                <div class="mb-3">
                    <x-forms.label id="max_point">Max. Poin</x-forms.label>
                    <x-forms.input type="number" name="max_point" min="0" />
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