<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
class CleanUrlParams
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $url = $request->url();
        // // Chuyển %20 thành khoảng trắng
        // $url = urldecode($url);
        // // Loại bỏ dấu tiếng Việt
        // $url = $this->removeAccents($url);
        // // Thay thế khoảng trắng bằng dấu gạch ngang
        // $url = $this->replaceSpaceWithDash($url);
        // // Chuyển hướng đến URL mới nếu cần
        // if ($url !== $request->url()) {
        //     return redirect()->to($url);
        // }
        return $next($request);
    }
    private function removeAccents($str) {
        // Code loại bỏ dấu tiếng Việt ở đây
        $str = mb_strtolower($str, 'UTF-8');
        $str = preg_replace('/(à|á|ả|ã|ạ|ă|ằ|ắ|ẳ|ẵ|ặ|â|ầ|ấ|ẩ|ẫ|ậ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẻ|ẽ|ẹ|ê|ề|ế|ể|ễ|ệ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ỉ|ĩ|ị)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ỏ|õ|ọ|ô|ồ|ố|ổ|ỗ|ộ|ơ|ờ|ớ|ở|ỡ|ợ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ủ|ũ|ụ|ư|ừ|ứ|ử|ữ|ự)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỷ|ỹ|ỵ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        //dd('cc');
        return $str;
    }
    private function replaceSpaceWithDash($str) {
        // Code thay thế khoảng trắng bằng dấu gạch ngang ở đây
        return str_replace(' ', '-', $str);
        return $str;
    }
}
