<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClassesTemplateExport implements WithHeadings, ShouldAutoSize
{

    public function headings(): array
    {
        return [
            "Nama Kelas",
            "Wali Kelas (ID Guru)",
        ];
    }
}
