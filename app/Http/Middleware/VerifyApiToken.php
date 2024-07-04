<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // protected $except = [
    //     'login', // Phương thức login trong controller sẽ không được xác thực
    // ];
    public function handle(Request $request, Closure $next): Response{
        // Kiểm tra xem token đã được gửi trong cookie "token" chưa
        $token = $request->cookie('token');
        if (!$token) {
            return response()->json(['error' => 'Bạn chưa đăng nhập, vui lòng đăng nhập.'], 401);
        }
        // Xác thực người dùng bằng token từ cookie
        try {
            $user = JWTAuth::parseToken($token)->authenticate();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token có thể đã hết hạn, không hợp lệ hoặc đã thay đổi.'], 401);
        }
        // Cho phép request tiếp tục nếu token hợp lệ và người dùng đã được xác thực
        return $next($request);
    }
}
