<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VuNuoi extends Model
{
    use HasFactory;
    protected $fillable =[

        'ma_vu','mua_vu','ngay_bat_dau','ngay_ket_thuc','ngay_tao','trang_thai','created_at','updated_at'
    ];
    protected $primaryKey = 'ma_vu';
    protected $table = 'vu_nuoi';
}
