<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetTokens extends Model
{
    use HasFactory;
    protected $fillable =[
        'email','token','created_at','updated_at'
    ];
    protected $primaryKey = 'email';
    protected $table = 'password_reset_tokens';
}
