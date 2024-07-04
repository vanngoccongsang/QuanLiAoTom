<?php

namespace App\Http\Controllers;

use App\Models\MoiTruong;
use App\Models\NhatKy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\VuNuoi;
use App\Models\KhuNuoi;
use Yajra\DataTables\DataTables;
use App\Models\AoNuoi;
use App\Models\ChiTietAo;
use Illuminate\Support\Carbon;
use App\Models\VatTu;
use Illuminate\Support\Facades\Redirect;
class MoiTruongController extends Controller
{
    public function __construct()
    {
        // Apply middleware to all controller methods
        $this->middleware('auth.check');
    }
    public function moi_truong(Request $request){
        $user = Auth::user();
        $lay_ao_nuoi = AoNuoi::orderBy('ma_ao','ASC')->get();
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','ASC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','ASC')->get();

        $lay_moi_truong = MoiTruong::query()
        ->join('chi_tiet_ao','chi_tiet_ao.id_chi_tiet_ao','=','moi_truong.id_chi_tiet_ao');

        if($request->has('lay_ao_loc') && $request->lay_ao_loc != null){
            $lay_moi_truong->where('ma_ao',$request->lay_ao_loc);
        }
        if($request->has('lay_khu_loc') && $request->lay_khu_loc != null){
            $lay_moi_truong->where('ma_khu',$request->lay_khu_loc);
        }
        if($request->has('lay_vu_loc') && $request->lay_vu_loc != null){
            $lay_moi_truong->where('ma_vu', $request->lay_vu_loc);
        }

        if($request->ajax()){
            return DataTables::of($lay_moi_truong)
            ->addColumn('thong_tin', function($lay_moi_truong){
                $ten_ao = AoNuoi::where('ma_ao',$lay_moi_truong->ma_ao)->first();
                $ten_khu = KhuNuoi::where('ma_khu',$lay_moi_truong->ma_khu)->first();
                $ten_vu = VuNuoi::where('ma_vu',$lay_moi_truong->ma_vu)->first();
                return  '<p style="color: rgb(246, 113, 113); font-size:14px; width:150px;">
                '.$ten_ao->ten_ao .' - '. $ten_khu->ten_khu.' - '. $ten_vu->ten_vu.'
                </p>';
            })
            ->addColumn('ngay', function($lay_moi_truong){
                $date = Carbon::parse($lay_moi_truong->ngay)->format('d/m/Y');
                return $date;
            })
            ->editColumn('do_kiem', '{{$do_kiem}} mg/L')
            ->editColumn('do_ph', '{{$do_ph}}')
            ->editColumn('to_khong_khi_sang', '{{$to_khong_khi_sang}} °C')
            ->editColumn('to_khong_khi_chieu', '{{$to_khong_khi_chieu}} °C')
            ->editColumn('to_nuoc_sang', '{{$to_nuoc_sang}} °C')
            ->editColumn('to_nuoc_chieu', '{{$to_nuoc_chieu}} °C')
            ->addColumn('Action', function($lay_moi_truong){
                return'
                <div class="dropdown">
                    <button class="dropbtn">Action</button>
                    <div class="dropdown-content">
                        <a href="/edit-moi-truong/'.$lay_moi_truong->id_moi_truong.'">
                            Sửa
                        </a>
                        <a href="/delete-moi-truong/'.$lay_moi_truong->id_moi_truong.'">
                            Xóa
                        </a>
                    </div>
                </div>
               ';
            })->rawColumns(['thong_tin','ngay','do_kiem','do_ph','to_khong_khi_sang','to_khong_khi_chieu','to_nuoc_sang','to_nuoc_chieu','Action'])
            ->make(true);
        }
        return view('admin.moi_truong.moi_truong',[
            'ao_nuoi' => $lay_ao_nuoi,
            'vu_nuoi' => $lay_vu_nuoi,
            'khu_nuoi' => $lay_khu_nuoi,
            'user' => $user
        ]);
    }
    public function add_moi_truong($id_chi_tiet_ao){
        // $save_mt = NhatKy::where('ma_ao',$id_nhat_ky)->get();
        //dd($id_chi_tiet_ao);
        $user = Auth::user();
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','ASC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','ASC')->get();
        $lay_ao_nuoi = AoNuoi::orderBy('ma_ao','ASC')->get();
        $lay_vat_tu = VatTu::orderBy('ma_vat_tu','ASC')->get();
        //dd($edit_ao);

        return view('admin.add.add_moi_truong',[
            'user' => $user,
            'vu_nuoi' => $lay_vu_nuoi,
            'khu_nuoi' => $lay_khu_nuoi,
            'ao_nuoi' => $lay_ao_nuoi,
            'vat_tu' => $lay_vat_tu,
            'id_chi_tiet_ao' => $id_chi_tiet_ao,
        ]);
    }
    public function save_moi_truong(Request $request){
        $user = Auth::user();
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','DESC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','DESC')->get();
        $data = $request->all();
        //dd($data);
        $moi_truong = new MoiTruong();
        $moi_truong->id_chi_tiet_ao = $data['id_chi_tiet_ao'];
        $moi_truong->do_kiem = $data['do_kiem'];
        $moi_truong->do_ph = $data['do_ph'];
        $moi_truong->to_khong_khi_sang = $data['to_khong_khi_sang'];
        $moi_truong->to_khong_khi_chieu = $data['to_khong_khi_chieu'];
        $moi_truong->to_nuoc_sang = $data['to_nuoc_sang'];
        $moi_truong->to_nuoc_chieu = $data['to_nuoc_chieu'];
        //Kiem tra nhap thieu
        if( ($data['do_kiem'] == NULL) || ($data['do_ph'] == NULL) || ($data['to_khong_khi_sang'] == NULL) || ($data['to_khong_khi_chieu'] == NULL)
        || ($data['to_nuoc_sang'] == NULL) || ($data['to_nuoc_chieu'] == NULL)){
            Session::put('error','Vui lòng điền đầy đủ thông tin.!!!');
            return redirect()->back();
        }
        //KIem tra nhap trung
        $so_sanh = MoiTruong::get();
        foreach($so_sanh as $key => $ss){
            if($ss->id_chi_tiet_ao == $data['id_chi_tiet_ao']){
                Session::put('error','Ao này đã tồn tại chỉ số môi trường !!!');
                return redirect()->back();
            }
        }
        $moi_truong->save();
        Session::put('message','Thêm môi trường thành công');
        return redirect()->back()->with(
            'vu_nuoi' , $lay_vu_nuoi,
            'khu_nuoi', $lay_khu_nuoi,
            'user', $user
        );
    }
    public function edit_moi_truong($id_moi_truong){
        $this->authorize('edit.moi.truong');
        $user = Auth::user();
        $edit_moi_truong = MoiTruong::where('id_moi_truong',$id_moi_truong)->get();
        $id_cta = MoiTruong::where('id_moi_truong',$id_moi_truong)->first();
        if($id_cta){
            $chi_tiet_ao = ChiTietAo::where('id_chi_tiet_ao',$id_cta->id_chi_tiet_ao)->first();
        }
        $ten_ao = AoNuoi::where('ma_ao',$chi_tiet_ao->ma_ao)->first();
        $ten_khu = KhuNuoi::where('ma_khu',$chi_tiet_ao->ma_khu)->first();
        $ten_vu = VuNuoi::where('ma_vu',$chi_tiet_ao->ma_vu)->first();
        $ngay = Carbon::parse($chi_tiet_ao->ngay)->format('d/m/Y');
        return view('admin.moi_truong.edit_moi_truong',[
            'user' => $user,
            'edit_moi_truong'=>$edit_moi_truong,
            'ten_ao' => $ten_ao->ten_ao,
            'ten_khu' => $ten_khu->ten_khu,
            'ten_vu' => $ten_vu->ten_vu,
            'ngay' => $ngay,
        ]);
    }
    public function update_moi_truong($id_moi_truong, Request $request){
        $this->authorize('edit.moi.truong');
        $id_chi_tiet_ao = MoiTruong::where('id_moi_truong', $id_moi_truong)->first();
        $chi_tiet_ao = ChiTietAo::where('id_chi_tiet_ao', $id_chi_tiet_ao->id_chi_tiet_ao)->first();
        //dd($chi_tiet_ao);
        $data = array();
        $data['do_kiem'] = $request->do_kiem;
        $data['do_ph'] = $request->do_ph;
        $data['to_khong_khi_sang'] = $request->to_khong_khi_sang;
        $data['to_khong_khi_chieu'] = $request->to_khong_khi_chieu;
        $data['to_nuoc_sang'] = $request->to_nuoc_sang;
        $data['to_nuoc_chieu'] = $request->to_nuoc_chieu;
        if( ($data['do_kiem'] == NULL) || ($data['do_ph'] == NULL) || ($data['to_khong_khi_sang'] == NULL) || ($data['to_khong_khi_chieu'] == NULL)
        || ($data['to_nuoc_sang'] == NULL) || ($data['to_nuoc_chieu'] == NULL)){
            Session::put('error','Vui lòng điền đầy đủ thông tin.');
            return redirect('all-chi-tiet-mot-ngay/'.$chi_tiet_ao->ma_ao.'/'.$chi_tiet_ao->ma_khu.'/'.$chi_tiet_ao->ma_vu.'/'.$chi_tiet_ao->ngay.'');
        }
        MoiTruong::where('id_moi_truong',$id_moi_truong)->update($data);
        Session::put('message','Cập nhật môi trường thành công.');
        return redirect('all-chi-tiet-mot-ngay/'.$chi_tiet_ao->ma_ao.'/'.$chi_tiet_ao->ma_khu.'/'.$chi_tiet_ao->ma_vu.'/'.$chi_tiet_ao->ngay.'');
    }
}
