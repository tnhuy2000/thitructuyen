<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhongThi extends Model
{
    use HasFactory;
    protected $table = 'phongthi';
    protected $fillable = [
        'cathi_id',
        'maphong',
        'soluongthisinh',
        'ma_meeting',
        'ma_meeting',
        ];

}
