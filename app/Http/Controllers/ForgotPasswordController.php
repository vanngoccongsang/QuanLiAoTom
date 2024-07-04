<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\PasswordResetTokens;
use GuzzleHttp\Promise\Is;
use Illuminate\Support\Str;
class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        // Apply middleware to all controller methods
        $this->middleware('auth.check');
    }
    public function showLinkRequestForm()
    {
        return view('admin.reset_password.reset_password');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users'
        ]);
        $customer = User::where('email', $request->email)->first();

        $token = Str::random(40);
        $token_Data = [
            'email' => $request->email,
            'token' => $token,
        ];
        $check_update = PasswordResetTokens::where('email', $request->email)->first();
        //dd($check_update);
        if($check_update->update($token_Data)){
            Mail::to($request->email)->send(new ForgotPassword($customer, $token));
            return redirect()->back()->with('message','Gửi email thành công, vui lòng kiểm tra email.');
        }
        if(PasswordResetTokens::create($token_Data)){
            Mail::to($request->email)->send(new ForgotPassword($customer, $token));
            return redirect()->back()->with('message','Gửi email thành công, vui lòng kiểm tra email.');
        }
        return redirect()->back()->with('message','Gửi email thất bại, vui lòng kiểm tra lại.');
        //dd($customer);
    }
}
