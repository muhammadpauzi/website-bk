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
            {{ $title }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-bg-light fw-bold">ID</td>
                            <td>{{ $teacher->id }}</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">NIP</td>
                            <td>{{ $teacher->nip }}</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Nama Lengkap</td>
                            <td>{{ $teacher->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Email</td>
                            <td>
                                <a href="mailto:{{ $teacher->email }}">{{ $teacher->email }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Ditambahkan pada</td>
                            <td>{{ $teacher->created_at->format('d F Y H:i') }} ({{
                                $teacher->created_at->diffForHumans() }})</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Diubah pada</td>
                            <td>{{ $teacher->updated_at->format('d F Y H:i') }} ({{
                                $teacher->updated_at->diffForHumans() }})</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Aksi</td>
                            <td>
                                <a href="{{ route('teachers.edit', $teacher) }}" class="badge text-bg-primary">edit</a>
                                <form action="{{ route('teachers.destroy', $teacher) }}" class="d-inline-block"
                                    onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border-0 badge text-bg-danger fw-bold">hapus</button>
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