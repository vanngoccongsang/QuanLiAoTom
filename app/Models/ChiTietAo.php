<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietAo extends Model
{
    use HasFactory;
    protected $fillable =[
        'id_chi_tiet_ao','ma_ao','ma_khu','ma_vu','ngay','tuoi_tom','luong_thuc_an','luong_tom_giong','luong_tom_sp','ADG','FCR','size','hao_hut','tinh_trang','sl_nhan_chiet','tong_tien'
    ];
    protected $primaryKey = 'id_chi_tiet_ao';
    protected $table = 'chi_tiet_ao';
}
