<?php

namespace App\Http\Controllers;

use App\Models\KhuNuoi;
use App\Models\VatTu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Contracts\DataTable;
use Illuminate\Support\Facades\Auth;
use App\Models\VuNuoi;
use App\Models\AoNuoi;
use Yajra\DataTables\DataTables;
use App\Models\NhapVatTu;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;

class VatTuController extends Controller
{
    public function __construct()
    {
        // Apply middleware to all controller methods
        $this->middleware('auth.check');
    }
    public function all_vat_tu(Request $request){
        $user = Auth::user();
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','ASC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','ASC')->get();
        $lay_ao_nuoi = AoNuoi::orderBy('ma_ao','ASC')->get();
        $lay_vt_loc= VatTu::orderBy('ma_vat_tu','ASC')->get();
        $loai_vat_tu = VatTu::orderBy('ma_vat_tu','ASC')->select('loai_vat_tu')->distinct()->get();
        $lay_vat_tu = VatTu::query();
        // dd($lay_vat_tu_loc);
        if($request->has('vat_tu_lay_vt_loc') && $request->vat_tu_lay_vt_loc != null){
            $lay_vat_tu->where('ma_vat_tu', $request->vat_tu_lay_vt_loc);
        }
        if($request->has('vat_tu_lay_loai_loc') && $request->vat_tu_lay_loai_loc != null){
            $lay_vat_tu->where('loai_vat_tu', $request->vat_tu_lay_loai_loc);
        }
        if($request->ajax()){

            return DataTables::of($lay_vat_tu)
            ->editColumn('so_luong_nhap', function($lay_vat_tu){
                return '<span class="label label-danger" style="font-size: 13px;">'.number_format($lay_vat_tu->so_luong_nhap).'</span>';
            })
            ->editColumn('gia_vat_tu', function($lay_vat_tu){
                return '<span class="label label-danger" style="font-size: 13px;">'.number_format($lay_vat_tu->gia_vat_tu).' VND'.'</span>';
            })
            ->editColumn('so_luong_ton', function($lay_vat_tu){
                return '<span class="label label-warning" style="font-size: 13px;">'.number_format($lay_vat_tu->so_luong_ton).'</span>';
            })
            ->editColumn('gia_vat_tu_ton', function($lay_vat_tu){
                return '<span class="label label-warning" style="font-size: 13px;">'.number_format($lay_vat_tu->gia_vat_tu_ton).' VND'.'</span>';
            })
            ->addColumn('lich_su_nhap', function($lay_vat_tu){
                $action ='';
                if(Gate::allows('add.vat.tu')){
                    $action .='
                    <a href="/lich-su-nhap-vat-tu/'.$lay_vat_tu->ma_vat_tu.'">
                        Lịch sử
                    </a>';
                }
                return $action;
            })
            ->addColumn('Action', function($lay_vat_tu){
                $action ='
                <div class="dropdown">
                    <button class="dropbtn">Action</button>
                    <div class="dropdown-content">';
                    if(Gate::allows('edit.vat.tu')){
                        $action .='
                        <a href="/nhap-vat-tu/'.$lay_vat_tu->ma_vat_tu.'">
                            Nhập vật tư
                        </a>';
                    }
                    if(Gate::allows('edit.vat.tu')){
                        $action .='
                        <a href="/edit-vat-tu/'.$lay_vat_tu->ma_vat_tu.'">
                            Sửa vật tư
                        </a>';
                    }
                    if(Gate::allows('delete.vat.tu')){
                        $action .='
                        <a href="/delete-vat-tu/'.$lay_vat_tu->ma_vat_tu.'">
                            Xóa vật tư
                        </a>';
                    }
                    $action .='
                    </div>
                </div>
               ';
               return $action;
            } )->rawColumns(['so_luong_nhap','so_luong_ton','gia_vat_tu_ton','gia_vat_tu','Action','lich_su_nhap'])
            ->make(true);
        }
        return view('admin.vat_tu.all_vat_tu',[
            'vu_nuoi' => $lay_vu_nuoi,
            'khu_nuoi' => $lay_khu_nuoi,
            'ao_nuoi' => $lay_ao_nuoi,
            'vat_tu' => $lay_vt_loc,
            'user' => $user,
            'loai_vat_tu' => $loai_vat_tu,
        ]);
    }
    public function save_vat_tu(Request $request){
        $this->authorize('add.vat.tu');
        $user = Auth::user();
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','DESC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','DESC')->get();
        $data = $request->all();
        //dd($data);
        $vat_tu= new VatTu();
        // $vat_tu->ma_vat_tu = $data['ma_vat_tu'];
        $vat_tu->ten_vat_tu = $data['ten_vat_tu'];
        $vat_tu->loai_vat_tu = $data['loai_vat_tu'];
        $vat_tu->mo_ta = $data['mo_ta'];
        $vat_tu->nha_cung_cap = $data['nha_cung_cap'];
        // $vat_tu->so_luong_nhap = $data['so_luong_nhap'];
        // $vat_tu->so_luong_ton = $vat_tu->so_luong_nhap;
        $vat_tu->don_vi = $data['don_vi'];
        // $vat_tu->gia_vat_tu = $data['gia_vat_tu'];
        if(($data['ten_vat_tu'] =='') || ($data['loai_vat_tu'] =='') || ($data['mo_ta'] =='') || ($data['nha_cung_cap'] =='')){
            Session::put('error','Vui lòng nhập đầy đủ thông tin!!!.');
            return Redirect::to('all-vat-tu');
        }
        $so_sanh = VatTu::get();
        foreach($so_sanh as $key => $ss){
            if(($ss->ten_vat_tu == $data['ten_vat_tu'])){
                Session::put('error','Vật tư này đã tồn tại!!!.');
                return Redirect::to('all-vat-tu');
            }
        }
        $vat_tu->save();
        Session::put('message','Thêm vật tư thành công.');
        return Redirect::to('all-vat-tu');
    }
    public function delete_vat_tu($ma_vat_tu){
        $this->authorize('delete.vat.tu');
        $user = Auth::user();
        $check_vat_tu = VatTu::where('ma_vat_tu',$ma_vat_tu)->first();
        //dd($check_vat_tu->so_luong_ton);
        if($check_vat_tu->so_luong_ton != 0){
            Session::put('error','Còn số lượng tồn kho, không thể xóa.');
            return Redirect::to('all-khu-nuoi');
        }
        VatTu::where('ma_vat_tu',$ma_vat_tu)->delete();
        Session::put('message','Xóa vật tư thành công.');
        return Redirect::to('all-vat-tu');
    }
    public function edit_vat_tu($ma_vat_tu){
        $this->authorize('edit.vat.tu');
        $user = Auth::user();
        $edit_vat_tu = VatTu::where('ma_vat_tu',$ma_vat_tu)->get();
        //dd($edit_vat_tu);

        return view('admin.vat_tu.edit_vat_tu',[
            'edit_vat_tu'=>$edit_vat_tu,
            'user' => $user,
        ]);
    }
    public function update_vat_tu($ma_vat_tu, Request $request){
        $this->authorize('edit.vat.tu');
        $data = array();
        // $data['ma_vat_tu']=$request->ma_vat_tu;
        $data['ten_vat_tu']=$request->ten_vat_tu;
        $data['loai_vat_tu']=$request->loai_vat_tu;
        $data['mo_ta']=$request->mo_ta;
        $data['nha_cung_cap'] = $request->nha_cung_cap;
        $data['so_luong_nhap'] = $request->so_luong_nhap;
        // $data['so_luong_ton'] = $request->so_luong_ton;
        $data['don_vi']=$request->don_vi;
        $data['gia_vat_tu']=$request->gia_vat_tu;
        $so_sanh = VatTu::whereNot('ma_vat_tu', $ma_vat_tu)->get();
        foreach($so_sanh as $key => $ss){
            if(($ss->ten_vat_tu == $data['ten_vat_tu'])){
                Session::put('error','Vật tư này đã tồn tại!!!.');
                return Redirect::to('all-vat-tu');
            }
        }
        VatTu::where('ma_vat_tu',$ma_vat_tu)->update($data);
        Session::put('message','Cập nhật vật tư thành công.');
        return Redirect::to('all-vat-tu');
    }
    public function nhap_vat_tu($ma_vat_tu){
        $user = Auth::user();
        $lay_vat_tu = VatTu::where('ma_vat_tu',$ma_vat_tu)->get();
        //dd($lay_vat_tu);

        return view('admin.vat_tu.nhap_vat_tu',[
            'ma_vat_tu' => $ma_vat_tu,
            'lay_vat_tu'=>$lay_vat_tu,
            'user' => $user,
        ]);
    }
    public function save_nhap_vat_tu(Request $request, $ma_vat_tu){
        // $this->authorize('add.vat.tu');
        $data = $request->all();
        $nhap_vat_tu= new NhapVatTu();
        $nhap_vat_tu->ma_vat_tu = $ma_vat_tu;
        $nhap_vat_tu->ngay_nhap = $data['ngay_nhap'];
        $nhap_vat_tu->so_luong_nhap = $data['so_luong_nhap'];
        $nhap_vat_tu->gia_tien = $data['gia_tien'];
        if(($data['ngay_nhap'] =='') || ($data['so_luong_nhap'] =='')|| ($data['gia_tien'] =='')){
            Session::put('error','Vui lòng nhập đầy đủ thông tin!!!.');
            return Redirect::to('all-vat-tu');
        }
        $check_nhap_vat_tu = NhapVatTu::get();
        foreach($check_nhap_vat_tu as $check){
            if(($ma_vat_tu == $check->ma_vat_tu) && ($data['ngay_nhap'] == $check->ngay_nhap)){
                Session::put('error','Ngày nhập đã tồn tại.');
                return Redirect::to('all-vat-tu');
            }
        }

        $update_vat_tu =  VatTu::where('ma_vat_tu', $ma_vat_tu)->first();
        $update_vat_tu->update([
            'so_luong_nhap' => $update_vat_tu->so_luong_nhap + $data['so_luong_nhap'],
            'gia_vat_tu' => $update_vat_tu->gia_vat_tu + $data['gia_tien'],
            'so_luong_ton' => $update_vat_tu->so_luong_ton + $data['so_luong_nhap'],
            'gia_vat_tu_ton' => $update_vat_tu->gia_vat_tu_ton + $data['gia_tien'],
        ]);
        $nhap_vat_tu->save();
        Session::put('message','Nhập vật tư thành công.');
        return Redirect::to('all-vat-tu');
    }
    public function lich_su_nhap_vat_tu(Request $request, $ma_vat_tu){
        $user = Auth::user();
        $ma_vat_tu_end = trim($ma_vat_tu, '.');
        $lay_ten_vat_tu= VatTu::where('ma_vat_tu',$ma_vat_tu_end)->first();
        $lay_lich_su_nhap_vat_tu = NhapVatTu::query()->where('ma_vat_tu',$ma_vat_tu_end);
        //dd($lay_lich_su_nhap_vat_tu);
        // if($request->has('vat_tu_lay_ls_loc') && $request->vat_tu_lay_ls_loc != null){
        //     $lay_lich_su_nhap_vat_tu->where('ma_vat_tu', $request->vat_tu_lay_ls_loc);
        // }
        if($request->ajax()){

            return DataTables::of($lay_lich_su_nhap_vat_tu)
            ->editColumn('id_nhap_vat_tu', function(){
                static $stt = 0;
                $stt++;
                return $stt;
            })
            ->editColumn('gia_tien', function($row){
                return '<span class="label label-warning" style="font-size: 13px;">'.number_format($row->gia_tien).' VND'.'</span>';
            })
            ->editColumn('ngay_nhap', function($row){
                $date = Carbon::parse($row->ngay_nhap)->format('d/m/Y');
                return $date;
            })
            ->editColumn('so_luong_nhap', function($row){
                $lay_don_vi_vt = VatTu::where('ma_vat_tu',$row->ma_vat_tu)->first();
                return number_format($row->so_luong_nhap).' ('.$lay_don_vi_vt->don_vi.')';
            })
            // ->editColumn('ma_vat_tu', function($row){
            //     $lay_ten_vt = VatTu::where('ma_vat_tu',$row->ma_vat_tu)->first();
            //     return $lay_ten_vt->ten_vat_tu;
            // })
            ->rawColumns(['so_luong_nhap','gia_tien','id_nhap_vat_tu'])
            ->make(true);
        }
        return view('admin.vat_tu.lich_su_nhap_vat_tu',[
            'lay_ten_vat_tu' => $lay_ten_vat_tu,
            'user' => $user,
            'ma_vat_tu' => $ma_vat_tu,
        ]);
    }
}
