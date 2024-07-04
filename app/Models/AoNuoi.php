<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AoNuoi extends Model
{
    use HasFactory;
    protected $fillable =[
        'ma_ao','ten_ao','ma_khu','ma_vu','loai_ao','dien_tich','hinh_dang','id_khach_hang','doanh_thu','tong_chi','loi_nhuan','trang_thai','ao_cha','created_at','updated_at'
    ];
    protected $primaryKey = 'ma_ao';
    protected $table = 'ao';
}
