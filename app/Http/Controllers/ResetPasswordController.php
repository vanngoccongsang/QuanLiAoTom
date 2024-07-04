<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Notifications\ResetPassword;

use SendsPasswordResetEmails;
class ResetPasswordController extends Controller
{
    protected $redirectTo = '/'; // Đường dẫn sau khi đặt lại mật khẩu thành công
    public function showResetForm()
    {
        return view('admin.reset_password.form_reset_password');
    }
    public function reset_password(Request $request, $token)
    {

    }
}
