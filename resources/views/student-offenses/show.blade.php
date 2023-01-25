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
        <div class="card-header">
            {{ $title }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-bg-light fw-bold">ID</td>
                            <td>{{ $student->id }}</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">NIS</td>
                            <td>{{ $student->nis }}</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">NISN</td>
                            <td>{{ $student->nisn }}</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Nama Lengkap</td>
                            <td>{{ $student->name }}</td>
                        </tr>
                        @if ($student?->class)
                        <tr>
                            <td class="text-bg-light fw-bold">Kelas</td>
                            <td>
                                <a href="{{ route('classes.show', optional($student->class)->id) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $student->class->name }}</a>
                            </td>
                        </tr>
                        @endif
                        @if ($student?->parent)
                        <tr>
                            <td class="text-bg-light fw-bold">Orang Tua</td>
                            <td>
                                <a href="{{ route('parents.show', $student->parent->id) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $student->parent->name }}</a>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-bg-light fw-bold">Email</td>
                            <td>
                                <a href="mailto:{{ $student->email }}">{{ $student->email }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Ditambahkan pada</td>
                            <td>{{ $student->created_at->format('d F Y H:i') }} ({{
                                $student->created_at->diffForHumans() }})</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Diubah pada</td>
                            <td>{{ $student->updated_at->format('d F Y H:i') }} ({{
                                $student->updated_at->diffForHumans() }})</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Aksi</td>
                            <td>
                                <a href="{{ route('students.edit', $student) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">edit</a>
                                <form action="{{ route('students.destroy', $student) }}" class="d-inline-block"
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