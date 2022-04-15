<?php

namespace App\Imports;

use App\Models\PhongThi;
use App\Models\SinhVien;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class SinhVienImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $isExistSV = SinhVien::select("*")
            ->where("masinhvien", $row['mssv'])
            ->doesntExist();
        
        if($isExistSV){
            $dataSV= new  SinhVien();
            $dataSV->masinhvien=$row['mssv'];
            $dataSV->holot=$row['ho'];
            $dataSV->ten=$row['ten_dem_va_ten'];
            $dataSV->email=$row['dia_chi_email'];
            $dataSV->dienthoai=$row['dien_thoai'];
            $dataSV->malop=$row['lop'];
            $dataSV->save();

            $name=$row['ho'].' '.$row['ten_dem_va_ten'];
            $data = new User();
            $data->masinhvien = $row['mssv'];
            $data->username = $row['mssv'];
            $data->name = $name;
            $data->email = $row['dia_chi_email'];
            $data->password = Hash::make($row['mssv']);
            $data->role=5;
            $data->save();
        }
        else
        {
            DB::table('sinhvien')->where('masinhvien', $row['mssv'])->update([
                'holot' => $row['ho'],
                'ten' => $row['ten_dem_va_ten'],
                'dienthoai' => $row['dien_thoai'],
                'email' => $row['dia_chi_email'],
                'malop' => $row['lop'],
            ]);
            $name= $row['ho'].' '.$row['ten_dem_va_ten'];
            DB::table('users')->where('masinhvien', $row['mssv'])->update([
                'name' => $name,
                'email' => $row['dia_chi_email'],
                
            ]);
            //toastr()->error('Sinh viên có mã '.$row['mssv'].' đã tồn tại');
        }
    }
    public function headingRow(): int
    {
    return 6;
    }
}
