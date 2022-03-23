<?php

namespace App\Imports;

use App\Models\User;
use App\Models\SinhVien;
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
        $isExist = SinhVien::select("*")
            ->where("masinhvien", $row['ma_sinh_vien'])
            ->exists();
        $isNotExistUser = User::select("*")
            ->where("masinhvien", $row['ma_sinh_vien'])
            ->doesntExist();
        if($isExist){
            if($isNotExistUser){
                if($role=='5'){
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
                elseif($user->role=='2'){

                }
                elseif($user->role=='3'){
                    
                }
                elseif($user->role=='4'){
                    
                }
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
    public function headingRow(): int
    {
    return 6;
    }
}
