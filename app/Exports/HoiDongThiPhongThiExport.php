<?php

namespace App\Exports;

use App\Models\HoiDongThi_PhongThi;
use Maatwebsite\Excel\Concerns\FromCollection;

class HoiDongThiPhongThiExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return HoiDongThi_PhongThi::all();
    }
}
