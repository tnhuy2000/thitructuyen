<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuLieuDeThi extends Model
{
    use HasFactory;
    protected $table = 'dulieudethi';
    protected $fillable = ['dethi_id','duongdan','ghichu','thutuhienthi'];
}
