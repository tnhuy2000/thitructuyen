<?php

namespace App\Imports;

use App\Models\HoiDongThi_PhongThi;
use Maatwebsite\Excel\Concerns\ToModel;

class HoiDongThiPhongThiImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new HoiDongThi_PhongThi([
            //
        ]);
    }
}
