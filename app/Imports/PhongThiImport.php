<?php

namespace App\Imports;
use App\Models\DeThi_PhongThi;
use App\Models\CaThi;
use App\Models\PhongThi;
use Maatwebsite\Excel\Concerns\ToModel;

class PhongThiImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cathi = CaThi::where('tenca', $row['ca_thi'])->first();
        $phongthi= new PhongThi([
            'cathi_id' => $cathi->id,
            'maphong' => $row['ma_phong'],
            'soluongthisinh' => $row['so_luong_thi_sinh'],
            'ghi_chu' => $row['ghi_chu'],
            ]);
        //$dethi = DeThi::where('tendethi', $row['de_thi'])->first();
        return new DeThi_PhongThi([
            'dethi_id' => $row['de_thi'],
            'phongthi_id' => $phongthi->id,
            'ghichu' => $row['ghi_chu'],
            ]);
        return $phongthi;
    }
    public function headingRow(): int
    {
    return 6;
    }
}
