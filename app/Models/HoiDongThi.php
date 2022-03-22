<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoiDongThi extends Model
{
    use HasFactory;
    protected $table = 'hoidongthi';
    protected $fillable = [
        'macanbo',
        'holot',
        'ten',
        'email',
        'dienthoai',
        'makhoa',
        'vaitro',
        ];

    public function Khoa()
    {
        return $this->belongsTo('App\Models\Khoa', 'makhoa', 'makhoa');
    }
}
