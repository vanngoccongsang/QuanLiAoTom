<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    use HasFactory;
    protected $fillable =[
        'id_khach_hang','loai_khach_hang','ten_khach_hang','so_dien_thoai','dia_chi','ghi_chu','created_at','updated_at'

    ];
    protected $primaryKey = 'id_khach_hang';
    protected $table = 'khach_hang';
}
