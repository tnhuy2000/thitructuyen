<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lop extends Model
{
    use HasFactory;
    protected $table = 'lop';
    protected $fillable = [
        'malop',
        'tenlop',
        'makhoa',
        'nienkhoa',
        ];

    public function Khoa()
    {
        return $this->belongsTo('App\Models\Khoa', 'makhoa', 'makhoa');
    }
}
