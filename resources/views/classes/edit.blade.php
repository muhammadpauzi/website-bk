@extends('layouts.app')


@section('content')
<div class="col-lg-8 col-md-7">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('classes.index') }}" class="btn btn-sm btn-light border">
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
            <form action="{{ route('classes.update', $class) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <x-forms.label id="name">Nama Kelas</x-forms.label>
                    <x-forms.input name="name" :value="old('name', $class->name)" />
                </div>

                <div class="mb-3">
                    <x-forms.label id="wali_kelas_id">Wali Kelas</x-forms.label>
                    <x-forms.tom-select id="wali_kelas_id" name="wali_kelas_id"
                        placeholder="Pilih guru sebagai wali kelas...">
                        @foreach ($teachers as $teacher)
                        <option @selected($teacher->id == old('wali_kelas_id', $class->wali_kelas_id)) value="{{
                            $teacher->id }}">{{
                            $teacher->nip }} - {{
                            $teacher->name }}</option>
                        @endforeach
                    </x-forms.tom-select>
                </div>

                <div class="mb-3">
                    <x-forms.label id="student_ids" :required="false">Siswa</x-forms.label>
                    <x-forms.tom-select id="student_ids" name="student_ids[]" placeholder="Pilih siswa-siswa..."
                        multiple>
                        @foreach ($students as $student)
                        <option @selected(in_array($student->id, old('student_ids', $studentIds))) value="{{
                            $student->id }}">
                            <b>{{
                                $student->nis }}</b> / <b>{{
                                $student->nisn }}</b> - {{
                            $student->name }}
                        </option>
                        @endforeach
                    </x-forms.tom-select>
                </div>

                <div class="d-flex align-items-center justify-content-end">
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