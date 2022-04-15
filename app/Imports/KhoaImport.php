<?php
namespace App\Imports;
use App\Models\Khoa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class KhoaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $isExist = Khoa::select("*")
            ->where("makhoa", $row['ma_khoa'])
            ->orWhere("tenkhoa",$row['ten_khoa'])
            ->doesntExist();
        if($isExist){
            return new Khoa([
            'makhoa' => $row['ma_khoa'],
            'tenkhoa' => $row['ten_khoa'],
            ]);
        }
        else
        {
            toastr()->error('Khoa '.$row['ten_khoa'].' đã tồn tại');
        }
    }
    public function headingRow(): int
    {
        return 6;
    }
}
