<?php

namespace App\Imports;
use Illuminate\Support\Facades\Hash;
use App\Models\CaThi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class CaThiImport implements ToModel, WithHeadingRow
{
    private $kythi_id; 

    public function __construct($kythi_id)
    {
        $this->kythi_id = $kythi_id; 
    }
    public function model(array $row)
    {
       
        //$timestamp= strtotime( $row['ngay_thi']);
        $date= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['ngay_thi'])->format('Y-m-d');
       // $date= date('Y-m-d', $timestamp );
        
        //dd($row['ngay_thi']);
       $subject=$row['gio_bat_dau'];
       $search = ['g'];
       $replace   = ':';
       $result = str_replace($search, $replace, $subject);						
        
       $kythi_id = $this->kythi_id;
       
        return new CaThi([
        'kythi_id' => $kythi_id,
        'tenca' => $row['ca_thi'],
        'ngaythi' => $date,
        'giobatdau' => $result,
        'matkhaucathi' => Hash::make($row['mat_khau_ca_thi']),
        ]);
    }
    public function headingRow(): int
    {
        return 6;
    }
}
