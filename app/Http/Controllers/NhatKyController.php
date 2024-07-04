<?php

namespace App\Http\Controllers;

use App\Models\MoiTruong;
use App\Models\NhatKy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\VuNuoi;
use App\Models\KhuNuoi;
use App\Models\VatTu;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;
use App\Models\AoNuoi;
use App\Models\ChiTietAo;
use Illuminate\Support\Facades\Redirect;

class NhatKyController extends Controller
{
    public function __construct()
    {
        // Apply middleware to all controller methods
        $this->middleware('auth.check');
    }
    public function nhat_ky(Request $request){
        $user = Auth::user();
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','ASC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','ASC')->get();
        $lay_ao_nuoi = AoNuoi::orderBy('ma_ao','ASC')->get();

        $lay_nhat_ky = NhatKy::query()
        ->leftjoin('chi_tiet_ao','chi_tiet_ao.id_chi_tiet_ao','=','nhat_ky.id_chi_tiet_ao')
        ->leftjoin('vat_tu','vat_tu.ma_vat_tu','=','nhat_ky.ma_vat_tu')
        ->select('nhat_ky.*','chi_tiet_ao.*','vat_tu.ten_vat_tu','vat_tu.don_vi');
        //dd($lay_nhat_ky);
        if($request->has('lay_ao_loc') && $request->lay_ao_loc != null){
            $lay_nhat_ky->where('ma_ao',$request->lay_ao_loc);
        }
        if($request->has('lay_khu_loc') && $request->lay_khu_loc != null){
            $lay_nhat_ky->where('ma_khu',$request->lay_khu_loc);
        }
        if($request->has('lay_vu_loc') && $request->lay_vu_loc != null){
            $lay_nhat_ky->where('ma_vu', $request->lay_vu_loc);
        }
        if($request->ajax()){
            return DataTables::of($lay_nhat_ky)
            ->filterColumn('tuoi_tom', function($query, $keyword) {
                $sql = "CONCAT(chi_tiet_ao.tuoi_tom) LIKE ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            // ->filterColumn('ten_khu', function($query, $keyword) {
            //     $sql = "CONCAT(chi_tiet_ao.ten_khu) LIKE ?";
            //     $query->whereRaw($sql, ["%{$keyword}%"]);
            // })
            // ->filterColumn('ten_vu', function($query, $keyword) {
            //     $sql = "CONCAT(chi_tiet_ao.ten_vu) LIKE ?";
            //     $query->whereRaw($sql, ["%{$keyword}%"]);
            // })
            ->addColumn('TT', function($row) {
                $ten_ao = AoNuoi::where('ma_ao', $row->ma_ao)->first();
                $ten_khu = KhuNuoi::where('ma_khu', $row->ma_khu)->first();
                $ten_vu = VuNuoi::where('ma_vu', $row->ma_vu)->first();
                return  '<p style="color: rgb(246, 113, 113); font-size:14px;">
                            '.$ten_ao->ten_ao .' - '. $ten_khu->ten_khu.' - '. $ten_vu->ten_vu.'
                        </p>';
            })
            ->addColumn('ngay', function($row) {
                return $row->ngay;
            })
            ->addColumn('ten_vat_tu', function($row) {
                return $row->ten_vat_tu;
            })
            ->addColumn('don_vi', function($row) {
                return $row->don_vi;
            })
            ->addColumn('tuoi', function($row) {
                return optional($row->chi_tiet_ao)->tuoi_tom;
            })
            ->editColumn('ngay', function($row) {
                $date = Carbon::parse($row->ngay)->format('d/m/Y');
                return $date;
            })
            ->editColumn('so_luong', function($row) {
                if($row->so_luong ==''){
                    return '';
                }
                return number_format($row->so_luong);
            })
            ->editColumn('gia_tien', function($row) {
                if($row->gia_tien ==''){
                    return '';
                }
                return number_format($row->gia_tien).' VNĐ';
            })
            ->editColumn('ghi_chu', function($row) {
                if($row->ghi_chu ==''){
                    return '';
                }
                return $row->ghi_chu;
            })
            // ->addColumn('Action', function($row){
            //     return'
            //     <div class="dropdown">
            //         <button class="dropbtn">Action</button>
            //         <div class="dropdown-content">
            //             <a href="/edit-nhat-ky/'.$row->id_nhat_ky.'" >
            //                 Sửa nhật ký
            //             </a>
            //             <a href="/delete-nhat-ky/'.$row->id_nhat_ky.'">
            //                 Xóa nhật ký
            //             </a>
            //         </div>
            //     </div>
            //    ';
            // })
            ->rawColumns(['ten_ao','TT','ngay','tuoi','ghi_chu','ten_vat_tu','Action','so_luong'])
            ->toJson();
        }
        return view('admin.nhat_ky',[
            'lay_ao_nuoi' => $lay_ao_nuoi,
            'lay_vu_nuoi' => $lay_vu_nuoi,
            'lay_khu_nuoi' => $lay_khu_nuoi,
            'user' => $user
        ]);
    }
    public function add_nhat_ky($id_chi_tiet_ao){
        $user = Auth::user();
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','DESC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','DESC')->get();
        $lay_vat_tu = VatTu::orderBy('ma_vat_tu','DESC')->get();
        //dd($edit_ao);
        return view('admin.add.add_nhat_ky',[
            'user' => $user,
            'vu_nuoi' => $lay_vu_nuoi,
            'vat_tu' => $lay_vat_tu,
            'khu_nuoi' => $lay_khu_nuoi,
            'id_chi_tiet_ao' => $id_chi_tiet_ao,
        ]);
    }
    public function save_nhat_ky(Request $request){
        $user = Auth::user();
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','ASC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','ASC')->get();
        $lay_ao_nuoi = AoNuoi::orderBy('ma_ao','ASC')->get();

        $data = $request->all();
        $nhat_ky = new NhatKy();
        $nhat_ky->id_chi_tiet_ao = $data['id_chi_tiet_ao'];
        $nhat_ky->ten_cu = $data['ten_cu'];
        $nhat_ky->ma_vat_tu = $data['ma_vat_tu'];
        $nhat_ky->so_luong = $data['so_luong'];
        $nhat_ky->ghi_chu = $data['ghi_chu'];
        //dd($data['ten_cu']);
        if( ($data['ten_cu'] == NULL) || ($data['ma_vat_tu'] == NULL) || ($data['so_luong'] == NULL)){
            Session::put('error','Vui lòng điền đầy đủ thông tin.!!!');
            return redirect()->back();
        }
        $lay_nhat_ky = NhatKy::all();
        foreach($lay_nhat_ky as $ss){
            if( ($ss->ten_cu == $data['ten_cu']) && ($ss->id_chi_tiet_ao == $data['id_chi_tiet_ao'])){
                Session::put('error','Cử đã tồn tại.!!!');
                return redirect()->back();
            }
        }
        $lay_vat_tu = VatTu::where('ma_vat_tu', $data['ma_vat_tu'])->first();
        //dd($lay_vat_tu);
        $lay_chi_tiet = ChiTietAo::where('id_chi_tiet_ao', $data['id_chi_tiet_ao'])->first();
        if($lay_vat_tu && $lay_chi_tiet){
            $nhat_ky->gia_tien = (($data['so_luong'] / $lay_vat_tu->so_luong_ton) * $lay_vat_tu->gia_vat_tu_ton);
            if($data['so_luong'] > $lay_vat_tu->so_luong_ton){
                Session::put('message','Số lượng trong kho không đủ!!!.');
                return redirect()->back();
            }
            if($lay_vat_tu->loai_vat_tu == "Thức ăn"){
                ChiTietAo::where('id_chi_tiet_ao', $data['id_chi_tiet_ao'])->update([
                    'luong_thuc_an' => $lay_chi_tiet->luong_thuc_an += $data['so_luong'],
                    'tong_tien' => $lay_chi_tiet->tong_tien += $nhat_ky->gia_tien
                ]);
            }elseif($lay_vat_tu->loai_vat_tu == "Tôm giống"){
                ChiTietAo::where('id_chi_tiet_ao', $data['id_chi_tiet_ao'])->update([
                    'luong_tom_giong' => $lay_chi_tiet->luong_tom_giong += $data['so_luong'],
                    'tong_tien' => $lay_chi_tiet->tong_tien += $nhat_ky->gia_tien
                ]);
            }else{
                //vd: Thuoc khu khuan
                ChiTietAo::where('id_chi_tiet_ao', $data['id_chi_tiet_ao'])->update([
                    'tong_tien' => $lay_chi_tiet->tong_tien += $nhat_ky->gia_tien
                ]);
            }
            $new_so_luong_ton = $lay_vat_tu->so_luong_ton - $data['so_luong'];
            $gia_vat_tu_ton = $lay_vat_tu->gia_vat_tu_ton - $nhat_ky->gia_tien;
            VatTu::where('ma_vat_tu', $data['ma_vat_tu'])->update([
                'so_luong_ton' =>  $new_so_luong_ton,
                'gia_vat_tu_ton' => $gia_vat_tu_ton
            ]);
        }
        //dd($nhat_ky->gia_tien);
        $nhat_ky->save();
        Session::put('message','Thêm nhật ký nuôi thành công');
        return redirect()->back()->with(
            'vu_nuoi', $lay_vu_nuoi,
            'khu_nuoi', $lay_khu_nuoi,
            'ao_nuoi', $lay_ao_nuoi,
            'user', $user
        );
    }
    public function delete_nhat_ky($id_nhat_ky){
        $user = Auth::user();
        //dd($ma_ao);
        NhatKy::where('id_nhat_ky',$id_nhat_ky)->delete();
        Session::put('message','Xóa nhật ký nuôi thành công');
        return Redirect::to('nhat-ky');
    }
}
