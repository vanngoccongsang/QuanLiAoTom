<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiaTom extends Model
{
    use HasFactory;
    protected $fillable =[
        'id','ngay_ban','gia_ban','created_at','updated_at'
    ];
    protected $primaryKey = 'id';
    protected $table = 'gia_tom';
}
