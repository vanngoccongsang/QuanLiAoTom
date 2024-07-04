<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable = ['id','ma_khu', 'latitude', 'longitude', 'created_at','updated_at'];
    protected $primaryKey = 'id';
    protected $table = 'location';
}
