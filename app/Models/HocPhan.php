<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HocPhan extends Model
{
    use HasFactory;
    protected $table = 'hocphan';
    protected $fillable = [
        'mahocphan',
        'tenhocphan',
        'sotinchi',
        ];
}
