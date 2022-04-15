<?php

namespace App\Imports;

use App\Models\PhongThi;
use App\Models\SinhVien_PhongThi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class SinhVienPhongThiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $phong = PhongThi::where('maphong', $row['phong_thi'])->first();

        return new SinhVien_PhongThi([
        'phongthi_id' => $phong->id,
        'masinhvien' => $row['ma_sinh_vien'],
        'ghichu' => $row['ghi_chu'],
        ]);
    }
    public function headingRow(): int
    {
    return 6;
    }
}
