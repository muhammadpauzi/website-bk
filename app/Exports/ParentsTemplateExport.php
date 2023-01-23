<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ParentsTemplateExport implements WithHeadings, ShouldAutoSize
{

    public function headings(): array
    {
        return [
            "Nama Orang Tua",
            "Siswa / Anak (ID)",
            "Alamat",
            "No. HP",
            "Jenis Kelamin (L/P)",
        ];
    }
}
