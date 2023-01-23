<?php

namespace App\Imports;

use App\Models\_Parent;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ParentsImport implements ToModel, WithChunkReading, WithStartRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new _Parent([
            'name' => $row[0],
            'student_id' => $row[1],
            'alamat' => $row[2],
            'phone' => $row[3],
            'gender' => $row[4],
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
            '*.2' => 'required|max:512',
            '*.3' => 'required|max:15|numeric',
            '*.4' => 'required|in:l,p',
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            '0' => 'Nama Orang Tua',
            '1' => 'Siswa / Anak (ID)',
            '2' => 'Alamat',
            '4' => 'No. HP',
            '5' => 'Jenis Kelamin'
        ];
    }
}
