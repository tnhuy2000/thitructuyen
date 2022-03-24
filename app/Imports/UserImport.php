<?php

namespace App\Imports;

use App\Models\User;
use App\Models\SinhVien;
use App\Models\HoiDongThi;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class UserImport implements ToModel, WithHeadingRow
{
    private $data; 

    public function __construct($data)
    {
        $this->data = $data; 
    }
    public function model(array $row)
    {
        $role=$this->data;
       
       
       
        if($role==5){
            $isExistSV = SinhVien::select("*")
                ->where("masinhvien", $row['ma_sinh_vien'])
                ->exists();
            $isNotExistUserSV = User::select("*")
                ->where("masinhvien", $row['ma_sinh_vien'])
                ->doesntExist();
            if($isExistSV){
                if($isNotExistUser){
                        $sinhvien = SinhVien::where('masinhvien', $row['ma_sinh_vien'])->first();
                        $name=$sinhvien->holot.' '.$sinhvien->ten;
                        return new User([
                        'masinhvien' => $row['ma_sinh_vien'],
                        'name' => $name,
                        'username' => $row['ma_sinh_vien'],
                        'email' => $sinhvien->email,
                        'password' =>Hash::make($row['ma_sinh_vien']),
                        'role'=>$role,
                        ]);
                }
                else
                {
                    toastr()->error('Người dùng có mã '.$row['ma_sinh_vien'].' đã tồn tại');
                }
            }
            else
            {
                toastr()->error('Sinh viên có mã '.$row['ma_sinh_vien'].' không tồn tại');
            }
        }
        else{
            $isExistHDT = HoiDongThi::select("*")
                ->where("macanbo", $row['ma_can_bo'])
                ->exists();
             $isNotExistUserHDT = User::select("*")
                ->where("macanbo", $row['ma_can_bo'])
                ->doesntExist();
            if($isExistHDT){
                if($isNotExistUserHDT){
                        $hdt = HoiDongThi::where('macanbo', $row['ma_can_bo'])->first();
                        $name=$hdt->holot.' '.$hdt->ten;
                        return new User([
                        'macanbo' => $row['ma_can_bo'],
                        'name' => $name,
                        'username' => $row['ma_can_bo'],
                        'email' => $hdt->email,
                        'password' =>Hash::make($row['ma_can_bo']),
                        'role'=>$role,
                        ]);
                }
                else
                {
                    toastr()->error('Người dùng có mã '.$row['ma_can_bo'].' đã tồn tại');
                }
            }
            else
            {
                toastr()->error('Cán bộ có mã '.$row['ma_can_bo'].' không tồn tại');
            }
        }
    }
    public function headingRow(): int
    {
    return 6;
    }
}
