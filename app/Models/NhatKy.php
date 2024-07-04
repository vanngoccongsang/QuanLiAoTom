<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhatKy extends Model
{
    use HasFactory;

    protected $fillable =[
        'id_nhat_ky','id_chi_tiet_ao','ten_cu','ma_vat_tu','so_luong','don_vi','ghi_chu','created_at','updated_at'
    ];
    protected $primaryKey = 'id_nhat_ky';
    protected $table = 'nhat_ky';
}
