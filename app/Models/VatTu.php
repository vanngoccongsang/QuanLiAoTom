<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VatTu extends Model
{
    use HasFactory;
    protected $fillable =[
        'ma_vat_tu','ten_vat_tu','loai_vat_tu','mo_ta','nha_cung_cap','so_luong_nhap','so_luong_ton','gia_vat_tu_ton','don_vi','gia_vat_tu',
    ];
    protected $primaryKey = 'ma_vat_tu';
    protected $table = 'vat_tu';
}
