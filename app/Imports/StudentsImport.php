<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithChunkReading, WithStartRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Student([
            'nis' => $row[0],
            'nisn' => $row[1],
            'name' => $row[2],
            'email' => $row[3],
            'gender' => $row[4],
            'parent_id' => $row[5],
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
            '*.0' => 'required|numeric|unique:students,nis|digits:10',
            '*.1' => 'required|numeric|unique:students,nisn|digits:10',
            '*.2' => 'required|max:128',
            '*.3' => 'required|email',
            '*.4' => 'required|in:l,p',
            '*.5' => 'numeric',
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            '0' => 'NIS',
            '1' => 'NISN',
            '2' => 'Nama Lengkap Siswa',
            '3' => 'Email',
            '4' => 'Jenis Kelamin',
            '5' => 'Orang Tua (ID)'
        ];
    }
}
