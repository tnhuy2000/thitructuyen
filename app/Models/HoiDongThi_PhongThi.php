<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoiDongThi_PhongThi extends Model
{
    use HasFactory;
    protected $table = 'hoidongthi_phongthi';
    protected $fillable = [
        'phongthi_id',
        'macanbo',
        'ghichu',
        ];
}
