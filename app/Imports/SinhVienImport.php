<?php

namespace App\Imports;

use App\Models\SinhVien;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class SinhVienImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
       
        return new SinhVien([
        'masinhvien' => $row['ma_sinh_vien'],
        'holot' => $row['ho_lot'],
        'ten' => $row['ten'],
        'email' => $row['dia_chi_email'],
        'dienthoai' => $row['dien_thoai'],
        'malop' => $row['ma_lop'],
        ]);
    }
    public function headingRow(): int
    {
    return 6;
    }
}
