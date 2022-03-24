<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeThi_PhongThi extends Model
{
    use HasFactory;
    protected $table = 'dethi_phongthi';
    protected $fillable = ['dethi_id','phongthi_id','ghichu'];
}
