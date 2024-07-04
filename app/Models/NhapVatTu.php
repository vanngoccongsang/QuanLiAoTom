<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhapVatTu extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_nhap_vat_tu','ma_vat_tu','ngay_nhap','so_luong_nhap','gia_tien','created_at','updated_at'
    ];
    protected $primaryKey = 'id_nhap_vat_tu';
    protected $table = 'nhap_vat_tu';
}
