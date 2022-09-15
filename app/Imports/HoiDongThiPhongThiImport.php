<?php

namespace App\Imports;

use App\Models\HoiDongThi_PhongThi;
use App\Models\PhongThi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HoiDongThiPhongThiImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $phong = PhongThi::where('maphong', $row['phong_thi'])->first();

        return new HoiDongThi_PhongThi([
        'phongthi_id' => $phong->id,
        'macanbo' => $row['ma_can_bo'],
        'ghichu' => $row['ghi_chu'],
        ]);
    }
    public function headingRow(): int
    {
    return 6;
    }
}
