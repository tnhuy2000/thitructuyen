<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SinhVien_PhongThi extends Model
{
    use HasFactory;
    protected $table = 'sinhvien_phongthi';
    protected $fillable = [
        'phongthi_id',
        'masinhvien',
        'diemdanh',
        'ghichu',
        ];
}
