<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeachersTemplateExport implements WithHeadings, ShouldAutoSize
{

    public function headings(): array
    {
        return [
            "NIP",
            "Nama Lengkap Guru",
            "Email",
            "Jenis Kelamin (L/P)",
        ];
    }
}
