<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuLieuBaiThi extends Model
{
    use HasFactory;
    protected $table = 'dulieubaithi';
    protected $fillable = ['baithi_id','duongdan','dungluong'];
}
