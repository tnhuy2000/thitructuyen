<?php

namespace App\Imports;

use App\Models\HocPhan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class HocPhanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $isExist = HocPhan::select("*")
            ->where("mahocphan", $row['ma_hoc_phan'])
            ->doesntExist();
        
        if($isExist){
            return new HocPhan([
                'mahocphan' => $row['ma_hoc_phan'],
                'tenhocphan' => $row['ten_hoc_phan'],
                'sotinchi' => $row['so_tin_chi'],
                ]);
        }
        else
        {
            toastr()->error('Học phần '.$row['ma_hoc_phan'].' đã tồn tại');
        }
    }
    public function headingRow(): int
    {
    return 6;
    }
}
