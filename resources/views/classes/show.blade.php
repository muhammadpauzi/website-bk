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
            {{ $title }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-bg-light fw-bold">ID</td>
                            <td>{{ $class->id }}</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Nama Kelas</td>
                            <td>{{ $class->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Wali Kelas</td>
                            <td>
                                <a href="{{ route('teachers.show', $class->waliKelas->id) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $class->waliKelas->name }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Siswa</td>
                            <td>
                                @foreach ($class->students as $student)
                                <a href="{{ route('students.show', $student->id) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $student->name }}</a>
                                @if ($loop->iteration % 4 === 0)
                                <br />
                                @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Ditambahkan pada</td>
                            <td>{{ $class->created_at->format('d F Y H:i') }} ({{
                                $class->created_at->diffForHumans() }})</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Diubah pada</td>
                            <td>{{ $class->updated_at->format('d F Y H:i') }} ({{
                                $class->updated_at->diffForHumans() }})</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Aksi</td>
                            <td>
                                <a href="{{ route('classes.edit', $class) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">edit</a>
                                <form action="{{ route('classes.destroy', $class) }}" class="d-inline-block"
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