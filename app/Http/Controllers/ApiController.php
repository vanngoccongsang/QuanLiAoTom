<?php

namespace App\Http\Controllers;
use App\Models\AoNuoi;
use App\Models\ChiTietAo;
use App\Models\KhuNuoi;
use App\Models\MoiTruong;
use App\Models\NhatKy;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\Http\Middleware\VerifyApiToken;

class ApiController extends Controller
{

    public function __construct(){
        $this->middleware(VerifyApiToken::class)->except(['login']);
    }
    public function login(Request $request){
        // Kiểm tra dữ liệu đầu vào từ người dùng
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Nếu dữ liệu không hợp lệ, trả về thông báo lỗi
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        // Nếu dữ liệu hợp lệ, tiếp tục xử lý đăng nhập
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                // Sai tài khoản hoặc mật khẩu
                return response()->json(['error' => 'Sai tài khoản hoặc mật khẩu.'], 401);
            }
        } catch (JWTException $e) {
            // Lỗi này xảy ra khi JWTAuth không thể tạo ra token cho người dùng
            return response()->json(['error' => 'Không thể tạo token cho người dùng.'], 500);
        }
        // Trả về token khi đăng nhập thành công
        return response()->json([
            'token' => $token,
            'message' => 'Đăng nhập thành công.'
        ], 200)->header('Authorization', 'Bearer ' . $token)->withCookie(cookie('token', $token, 30));

    }
    public function logout(Request $request){
        // Invalidate JWT token on client side
        return response()->json([
            'message' => 'Successfully logged out'
        ])->cookie('token', '', 0);
    }
    public function all_ao_nuoi(){
        // $lay_chi_tiet = ChiTietAo::leftjoin('ao','ao.ma_ao','=','chi_tiet_ao.ma_ao')
        // ->leftjoin('khu_nuoi','khu_nuoi.ma_khu','=','chi_tiet_ao.ma_khu')
        // ->leftjoin('vu_nuoi','vu_nuoi.ma_vu','=','chi_tiet_ao.ma_vu')->get();
        // $lay_moi_truong = ChiTietAo::
        // leftjoin('moi_truong','chi_tiet_ao.id_chi_tiet_ao','=','moi_truong.id_chi_tiet_ao')
        // ->leftjoin('ao','ao.ma_ao','=','chi_tiet_ao.ma_ao')
        // ->leftjoin('khu_nuoi','khu_nuoi.ma_khu','=','chi_tiet_ao.ma_khu')
        // ->leftjoin('vu_nuoi','vu_nuoi.ma_vu','=','chi_tiet_ao.ma_vu')
        // ->select('ao.ten_ao','khu_nuoi.ten_khu','vu_nuoi.ten_vu','chi_tiet_ao.*','moi_truong.*')->get();
        $lay_nhat_ky = ChiTietAo::query()
        ->leftjoin('nhat_ky','chi_tiet_ao.id_chi_tiet_ao','=','nhat_ky.id_chi_tiet_ao')
        ->leftjoin('vat_tu','vat_tu.ma_vat_tu','=','nhat_ky.ma_vat_tu')
        ->leftjoin('ao','ao.ma_ao','=','chi_tiet_ao.ma_ao')
        ->leftjoin('khu_nuoi','khu_nuoi.ma_khu','=','chi_tiet_ao.ma_khu')
        ->leftjoin('vu_nuoi','vu_nuoi.ma_vu','=','chi_tiet_ao.ma_vu')
        ->select('ao.ten_ao','khu_nuoi.ten_khu','vu_nuoi.ten_vu','nhat_ky.*',
        'chi_tiet_ao.ngay','chi_tiet_ao.tuoi_tom','vat_tu.ten_vat_tu','vat_tu.don_vi')->get();
        return response()->json([
            'data' => $lay_nhat_ky,
            'status_code' => 200,
            'message' => 'ok',
        ]);
    }
    public function moi_truong(){
        $lay_moi_truong = MoiTruong::join('chi_tiet_ao','chi_tiet_ao.id_chi_tiet_ao','=','moi_truong.id_chi_tiet_ao')
        ->leftjoin('ao','ao.ma_ao','=','chi_tiet_ao.ma_ao')
        ->leftjoin('khu_nuoi','khu_nuoi.ma_khu','=','chi_tiet_ao.ma_khu')
        ->leftjoin('vu_nuoi','vu_nuoi.ma_vu','=','chi_tiet_ao.ma_vu')
        ->select('ao.ten_ao','khu_nuoi.ten_khu','vu_nuoi.ten_vu',
        'chi_tiet_ao.ngay','chi_tiet_ao.tuoi_tom','moi_truong.*')->get();
        return response()->json([
            'data' => $lay_moi_truong,
            'status_code' => 200,
            'message' => 'ok'
        ]);
    }
    public function save_moi_truong(Request $request){
        // Lấy dữ liệu từ request
        $data = $request->all();
        // Tạo mới môi trường
        $moi_truong = new MoiTruong();
        $moi_truong->id_chi_tiet_ao = $data['id_chi_tiet_ao'];
        $moi_truong->do_kiem = $data['do_kiem'];
        $moi_truong->do_ph = $data['do_ph'];
        $moi_truong->to_khong_khi_sang = $data['to_khong_khi_sang'];
        $moi_truong->to_khong_khi_chieu = $data['to_khong_khi_chieu'];
        $moi_truong->to_nuoc_sang = $data['to_nuoc_sang'];
        $moi_truong->to_nuoc_chieu = $data['to_nuoc_chieu'];
        // Kiểm tra nhập thiếu
        if (empty($data['do_kiem']) || empty($data['do_ph']) || empty($data['to_khong_khi_sang']) || empty($data['to_khong_khi_chieu']) || empty($data['to_nuoc_sang']) || empty($data['to_nuoc_chieu'])) {
            return response()->json(['error' => 'Vui lòng điền đầy đủ thông tin'], 400);
        }
        // Kiểm tra nhập trùng
        if (MoiTruong::where('id_chi_tiet_ao', $data['id_chi_tiet_ao'])->exists()) {
            return response()->json(['error' => 'Ao này đã tồn tại chỉ số môi trường'], 400);
        }
        // Lưu môi trường
        $moi_truong->save();
        // Trả về phản hồi thành công
        return response()->json(['message' => 'Thêm môi trường thành công'], 200);
    }
    public function update_moi_truong($id_moi_truong, Request $request){
        $moi_truong = MoiTruong::find($id_moi_truong);
        if(!$moi_truong) {
            return response()->json(['error' => 'Không tìm thấy môi trường'], 404);
        }
        $data = $request->validate([
            'do_kiem' => 'required',
            'do_ph' => 'required',
            'to_khong_khi_sang' => 'required',
            'to_khong_khi_chieu' => 'required',
            'to_nuoc_sang' => 'required',
            'to_nuoc_chieu' => 'required',
        ]);
        $moi_truong->update($data);
        return response()->json(['message' => 'Cập nhật môi trường thành công'], 200);
    }
    public function save_ao(Request $request){
        // Xử lý authorization nếu cần
        // $this->authorize('add.ao');
        $data = $request->all();
        $ao = new AoNuoi();
        $ao->ten_ao = $data['ten_ao'];
        $ao->ma_khu = $data['ma_khu'];
        $ao->ma_vu = $data['ma_vu'];
        $ao->loai_ao = $data['loai_ao'];
        $ao->dien_tich = $data['dien_tich'];
        $ao->hinh_dang = $data['hinh_dang'];
        $ao->trang_thai = 'Hoạt động';
        if(($data['ten_ao'] =='') || ($data['ma_khu'] =='') || ($data['ma_vu'] =='') ||
            ($data['loai_ao'] =='')|| ($data['dien_tich'] =='') || ($data['hinh_dang'] =='')){
            return response()->json(['error' => 'Vui lòng nhập đầy đủ thông tin.'], 400);
        }
        $existingAo = AoNuoi::where('ten_ao', $data['ten_ao'])
                            ->where('ma_khu', $data['ma_khu'])
                            ->where('ma_vu', $data['ma_vu'])
                            ->first();
        if ($existingAo) {
            return response()->json(['error' => 'Ao, khu, vụ này đã tồn tại!!!.'], 400);
        }
        $ao->save();
        return response()->json(['message' => 'Thêm ao nuôi thành công.'], 200);
    }
    public function update_ao($ma_ao, Request $request) {
        // Kiểm tra xác thực
        // $this->authorize('edit.ao');
        $data = $request->all();
        // Kiểm tra các trường bắt buộc
        $requiredFields = ['ten_ao', 'ma_khu', 'ma_vu', 'loai_ao', 'dien_tich', 'hinh_dang', 'trang_thai'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                return response()->json(['error' => 'Vui lòng nhập đầy đủ thông tin.'], 400);
            }
        }
        // Kiểm tra nếu tồn tại ao khác với thông tin mới
        $existingAo = AoNuoi::where('ma_ao', '!=', $ma_ao)
                            ->where('ten_ao', $data['ten_ao'])
                            ->where('ma_khu', $data['ma_khu'])
                            ->where('ma_vu', $data['ma_vu'])
                            ->first();
        if($existingAo) {
            return response()->json(['error' => 'Ao, khu, vụ này đã tồn tại!!!.'], 400);
        }
        // Cập nhật thông tin ao nuôi
        AoNuoi::where('ma_ao', $ma_ao)->update($data);
        // Cập nhật thông tin khu và vụ của chi tiết ao
        ChiTietAo::where('ma_ao', $ma_ao)->update([
            'ma_khu' => $data['ma_khu'],
            'ma_vu' => $data['ma_vu'],
        ]);
        return response()->json(['message' => 'Cập nhật ao nuôi thành công'], 200);
    }
}
