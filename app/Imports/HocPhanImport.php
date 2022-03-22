<?php

namespace App\Imports;

use App\Models\HocPhan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class HocPhanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
       
        return new HocPhan([
        'mahocphan' => $row['ma_hoc_phan'],
        'tenhocphan' => $row['ten_hoc_phan'],
        'sotinchi' => $row['so_tin_chi'],
        ]);
    }
    public function headingRow(): int
    {
    return 6;
    }
}
