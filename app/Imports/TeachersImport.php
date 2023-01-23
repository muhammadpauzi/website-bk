<?php

namespace App\Imports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TeachersImport implements ToModel, WithChunkReading, WithStartRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Teacher([
            'nip' => $row[0],
            'name' => $row[1],
            'email' => $row[2],
            'gender' => $row[3],
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
            '*.0' => 'required|numeric|unique:teachers,nip|digits:18',
            '*.1' => 'required|max:128',
            '*.2' => 'required|email',
            '*.3' => 'required|in:l,p',
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            '0' => 'NIP',
            '1' => 'Nama Lengkap Guru',
            '2' => 'Email',
            '3' => 'Jenis Kelamin'
        ];
    }
}
