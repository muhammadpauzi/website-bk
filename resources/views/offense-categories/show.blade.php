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
        <div class="card-header">
            {{ $title }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-bg-light fw-bold">ID</td>
                            <td>{{ $offenseCategory->id }}</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Nama Kategori</td>
                            <td>{{ $offenseCategory->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Poin</td>
                            <td>
                                <span
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">{{
                                    $offenseCategory->point }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Status Aktif</td>
                            <td>
                                @if ($offenseCategory->is_active)
                                <div class="badge text-success-emphasis bg-success-subtle border border-success-subtle">
                                    Aktif</div>
                                @else
                                <div class="badge text-danger-emphasis bg-danger-subtle border border-danger-subtle">
                                    Nonaktif</div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Keterangan</td>
                            <td>{!! nl2br($offenseCategory->description) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Ditambahkan pada</td>
                            <td>{{ $offenseCategory->created_at->format('d F Y H:i') }} ({{
                                $offenseCategory->created_at->diffForHumans() }})</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Diubah pada</td>
                            <td>{{ $offenseCategory->updated_at->format('d F Y H:i') }} ({{
                                $offenseCategory->updated_at->diffForHumans() }})</td>
                        </tr>
                        <tr>
                            <td class="text-bg-light fw-bold">Aksi</td>
                            <td>
                                <a href="{{ route('offense-categories.edit', $offenseCategory) }}"
                                    class="badge text-primary-emphasis bg-primary-subtle border border-primary-subtle">edit</a>
                                <form action="{{ route('offense-categories.destroy', $offenseCategory) }}"
                                    class="d-inline-block"
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