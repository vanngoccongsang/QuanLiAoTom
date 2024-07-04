<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhuNuoi extends Model
{
    use HasFactory;
    protected $fillable =[
        'ma_khu','ten_khu','dia_chi','trang_thai','created_at','updated_at'
    ];
    protected $primaryKey = 'ma_khu';
    protected $table = 'khu_nuoi';
}
