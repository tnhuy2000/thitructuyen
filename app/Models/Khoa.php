<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khoa extends Model
{
    use HasFactory;
    protected $table = 'khoa';
    protected $fillable = [
        'makhoa',
        'tenkhoa'
        ];

    public function Lop(){
        return $this->hasMany('App\Models\Lop', 'makhoa', 'makhoa');
    }
    public function HoiDongThi(){
        return $this->hasMany('App\Models\HoiDongThi', 'makhoa', 'makhoa');
    }
    
}
