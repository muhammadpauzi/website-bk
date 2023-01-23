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
        <div class="card-header">
            {{ $title }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-bg-light fw-bold">ID</td>
                            <td>{{ $parent->id }}</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Nama Lengkap</td>
                            <td>{{ $parent->name }}</td>
                        </tr>
                        @if ($parent?->students)
                        <tr>
                            <td class="text-bg-light fw-bold">Siswa / Anak</td>
                            <td>
                                @if ($parent?->students)
                                @foreach ($parent->students as $student)
                                <a href="{{ route('students.show', $student->id) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $student->name }}</a>
                                @if ($loop->iteration % 4 === 0)
                                <br />
                                @endif
                                @endforeach
                                @endif
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-bg-light fw-bold">Alamat</td>
                            <td>{!! nl2br($parent->alamat) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">No. HP</td>
                            <td>{{ $parent->phone }}</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Ditambahkan pada</td>
                            <td>{{ $parent->created_at->format('d F Y H:i') }} ({{
                                $parent->created_at->diffForHumans() }})</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Diubah pada</td>
                            <td>{{ $parent->updated_at->format('d F Y H:i') }} ({{
                                $parent->updated_at->diffForHumans() }})</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Aksi</td>
                            <td>
                                <a href="{{ route('parents.edit', $parent) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">edit</a>
                                <form action="{{ route('parents.destroy', $parent) }}" class="d-inline-block"
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