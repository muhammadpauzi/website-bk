@extends('layouts.app')

@section('content')
<div class="col-lg-7 col-md-6">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('student-offenses.index') }}" class="btn btn-sm btn-light border">
                <i data-feather="arrow-left" class="me-1 icon-size"></i>
                Kembali</a>
        </div>
        <div>

        </div>
    </div>
    <div class="card shadow-lg">
        <form action="{{ route('student-offenses.store') }}" method="POST">
            @csrf
            <div class="card-header">
                Form {{ $title }}
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <x-forms.label id="student_id">Siswa</x-forms.label>
                    <x-forms.tom-select id="student_id" name="student_id" placeholder="Pilih siswa...">
                        @foreach ($students as $student)
                        <option @selected($student->id == old('student_id')) value="{{ $student->id }}">{{
                            $student->nis }} - {{
                            $student->nisn }} - {{
                            $student->name }}</option>
                        @endforeach
                    </x-forms.tom-select>
                </div>
                <div class="mb-3">
                    <x-forms.label id="reporter_id">Guru Pelapor</x-forms.label>
                    <x-forms.tom-select id="reporter_id" name="reporter_id" placeholder="Pilih guru (pelapor)...">
                        @foreach ($teachers as $reporter)
                        <option @selected($reporter->id == old('reporter_id')) value="{{ $reporter->id }}">{{
                            $reporter->nip }} - {{
                            $reporter->name }}</option>
                        @endforeach
                    </x-forms.tom-select>
                </div>
                <div class="mb-3">
                    <x-forms.label id="offense_category_id">Kategori Pelanggaran</x-forms.label>
                    <x-forms.tom-select id="offense_category_id" name="offense_category_id"
                        placeholder="Pilih kategori pelanggaran...">
                        @foreach ($offenseCategories as $offenseCategory)
                        <option @selected($offenseCategory->id == old('offense_category_id')) value="{{
                            $offenseCategory->id }}">#{{
                            $offenseCategory->id }} - {{
                            $offenseCategory->name }} ({{
                            $offenseCategory->point }})</option>
                        @endforeach
                    </x-forms.tom-select>
                </div>
                <div class="mb-3">
                    <x-forms.label id="reported_at" :required="false">Dilaporkan pada</x-forms.label>
                    <x-forms.input class="flatpickr" name="reported_at" :value="old('reported_at')" />
                    <small class="text-muted">Jika tidak di-isi, secara bawaan akan di-isi dengan tanggal saat
                        ini</small>
                </div>
                <div class="mb-3">
                    <x-forms.label id="description" :required="false">Keterangan</x-forms.label>
                    <x-forms.textarea name="description"></x-forms.textarea>
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

@push('script')
<script>
    const flatpickrElements = document.querySelectorAll('.flatpickr');
    flatpickr(flatpickrElements, {
        altInput: true, 
        altFormat: "d F Y",
    });
</script>
@endpush