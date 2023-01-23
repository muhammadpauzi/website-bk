<?php

namespace App\Helpers;

use App\Models\Loan;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class BasicHelper
{
    public static function getInfoStatusPeminjamanBuku(Loan $model, $flat = false): string
    {
        if ($flat)
            return !$model->is_returned ?
                (Carbon::parse($model->tanggal_batas_pengembalian_buku)->isPast() ? 'Terlambat (' .
                    CarbonPeriod::create($model->tanggal_batas_pengembalian_buku, now())->count() . ' Hari)' : 'Sedang Dipinjam') : 'Sudah Dikembalikan';

        return !$model->is_returned ?
            (Carbon::parse($model->tanggal_batas_pengembalian_buku)->isPast() ? '<span class="badge text-bg-danger">Terlambat (' .
                CarbonPeriod::create($model->tanggal_batas_pengembalian_buku, now())->count() . ' Hari)</span>' : '<span class="badge text-bg-light border">Sedang Dipinjam</span>') : '<span class="badge text-bg-success">Sudah Dikembalikan</span>';
    }
}
