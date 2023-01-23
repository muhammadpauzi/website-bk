<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsTemplateExport implements WithHeadings, ShouldAutoSize
{

    public function headings(): array
    {
        return [
            "NIS",
            "NISN",
            "Nama Lengkap Siswa",
            "Email",
            "Jenis Kelamin (L/P)",
        ];
    }
}
