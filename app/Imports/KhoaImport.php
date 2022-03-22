<?php
namespace App\Imports;
use App\Models\Khoa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class KhoaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Khoa([
        'makhoa' => $row['ma_khoa'],
        'tenkhoa' => $row['ten_khoa'],
        ]);
    }
    public function headingRow(): int
    {
        return 6;
    }
}
