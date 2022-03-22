<?php

namespace App\Imports;

use App\Models\HoiDongThi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class HoiDongThiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
       
        return new HoiDongThi([
        'macanbo' => $row['ma_can_bo'],
        'holot' => $row['ho_lot'],
        'ten' => $row['ten'],
        'email' => $row['dia_chi_email'],
        'dienthoai' => $row['dien_thoai'],
        'makhoa' => $row['ma_khoa'],
        'vaitro' => $row['vai_tro'],
        ]);
    }
    public function headingRow(): int
    {
    return 6;
    }
}
