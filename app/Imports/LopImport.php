<?php
namespace App\Imports;
use App\Models\Lop;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class LopImport implements ToModel, WithHeadingRow
{
    

    public function model(array $row)
    {
       
        return new Lop([
        'malop' => $row['ma_lop'],
        'tenlop' => $row['ten_lop'],
        'makhoa' => $row['ma_khoa'],
        'nienkhoa' => $row['nien_khoa'],
        ]);
    }
    public function headingRow(): int
    {
    return 6;
    }
}