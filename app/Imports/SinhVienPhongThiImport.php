<?php

namespace App\Imports;

use App\Models\SinhVien_PhongThi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class SinhVienPhongThiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
       
        return new SinhVien_PhongThi([
        'phongthi_id' => $row['phong_id'],
        'masinhvien' => $row['ma_sinh_vien'],
        'diemdanh' => $row['diem_danh'],
        'ghichu' => $row['ghi_chu'],
        ]);
    }
    public function headingRow(): int
    {
    return 6;
    }
}
