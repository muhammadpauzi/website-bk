<?php

namespace App\Imports;

use App\Models\Class_;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ClassesImport implements ToModel, WithChunkReading, WithStartRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Class_([
            'name' => $row[0],
            'wali_kelas_id' => $row[1],
        ]);
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            '*.0' => 'required|max:128',
            '*.1' => 'required|numeric',
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            '0' => 'Nama Kelas',
            '1' => 'Wali Kelas (ID Guru)',
        ];
    }
}
