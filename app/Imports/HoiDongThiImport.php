<?php

namespace App\Imports;

use App\Models\HoiDongThi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class HoiDongThiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $isExistHDT = HoiDongThi::select("*")
        ->where("macanbo", $row['ma_can_bo'])
        ->doesntExist();
    
        if($isExistHDT){
            $vaitro='';
            $role=0;
            if($row['vai_tro']=='Cán bộ coi thi')
            {
                $vaitro='canbocoithi';
                $role=3;
            }
            elseif($row['vai_tro']=='Thư ký')
            {
                $vaitro='thuky';
                $role=2;
            }
            elseif($row['vai_tro']=='Hội đồng thi')
            {
                $vaitro='hoidongthi';
                $role=4;
            }
            $dataSV= new  HoiDongThi();
            $dataSV->macanbo=$row['ma_can_bo'];
            $dataSV->holot=$row['ho_lot'];
            $dataSV->ten=$row['ten'];
            $dataSV->email=$row['dia_chi_email'];
            $dataSV->dienthoai=$row['dien_thoai'];
            $dataSV->makhoa=$row['ma_khoa'];
            $dataSV->vaitro=$vaitro;
            $dataSV->save();

            $name=$row['ho_lot'].' '.$row['ten'];
            $data = new User();
            $data->macanbo = $row['ma_can_bo'];
            $data->username = $row['ma_can_bo'];
            $data->name = $name;
            $data->email = $row['dia_chi_email'];
            $data->password = Hash::make($row['ma_can_bo']);
            $data->role=$role;
            $data->save();
        }
        else
        {
            toastr()->error('Cán bộ có mã '.$row['ma_can_bo'].' đã tồn tại');
        }
        
    }
    public function headingRow(): int
    {
    return 6;
    }
}
