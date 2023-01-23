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
            'alamat' => $row[1],
            'phone' => $row[2],
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
            '*.0' => 'required|max:128',
            '*.1' => 'required|max:512',
            '*.2' => 'required|digits:20|numeric',
            '*.3' => 'required|in:l,p',
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            '0' => 'Nama Orang Tua',
            '1' => 'Alamat',
            '2' => 'No. HP',
            '3' => 'Jenis Kelamin'
        ];
    }
}
