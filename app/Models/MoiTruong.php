<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoiTruong extends Model
{
    use HasFactory;
    protected $fillable =[
        'id_moi_truong','id_nhat_ky','do_kiem','do_ph','to_khong_khi_sang','to_khong_khi_chieu','to_nuoc_sang','to_nuoc_chieu','created_at','updated_at',

    ];
    protected $primaryKey = 'id_moi_truong';
    protected $table = 'moi_truong';
}
