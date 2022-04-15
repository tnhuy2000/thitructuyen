<?php
namespace App\Imports;
use App\Models\Lop;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class LopImport implements ToModel, WithHeadingRow
{
    

    public function model(array $row)
    {
        $isExist = Lop::select("*")
            ->where("malop", $row['ma_lop'])
            ->doesntExist();
        
        if($isExist){
            return new Lop([
                'malop' => $row['ma_lop'],
                'tenlop' => $row['ten_lop'],
                'makhoa' => $row['ma_khoa'],
                'nienkhoa' => $row['nien_khoa'],
            ]);
        }
        else
        {
            toastr()->error('Lớp '.$row['ma_lop'].' đã tồn tại');
        }
    }
    public function headingRow(): int
    {
    return 6;
    }
}