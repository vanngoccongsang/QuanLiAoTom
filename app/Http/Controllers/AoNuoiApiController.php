<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AoNuoi;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\ChiTietAo;
class AoNuoiApiController extends Controller
{
    public function save_ao_nuoi(Request $request) {
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
        if ($existingAo) {
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
