<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VuNuoi;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\KhuNuoi;
use App\Models\AoNuoi;
use App\Models\VatTu;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Carbon;
class VuNuoiController extends Controller
{
    public function __construct()
    {
        // Apply middleware to all controller methods
        $this->middleware('auth.check');
    }
    public function vu_nuoi(Request $request){
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','ASC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','ASC')->get();
        $lay_ao_nuoi = AoNuoi::orderBy('ma_ao','ASC')->get();
        $lay_vat_tu = VatTu::orderBy('ma_vat_tu','ASC')->get();
        $lay_vu = VuNuoi::query();
        $user = Auth::user();
        if($request->has('vu_lay_vu_loc') && $request->vu_lay_vu_loc != null){
            $lay_vu->where('ma_vu', $request->vu_lay_vu_loc);
        }
        if($request->ajax()){

            return DataTables::of($lay_vu)
            ->addColumn('Action', function($lay_vu){
                return'
                <div class="btn-action">
                    <a href="/edit-vu/'.$lay_vu->ma_vu.'">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <a href="/delete-vu/'.$lay_vu->ma_vu.'">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </a>
                </div>
                ';
            } )->rawColumns(['Action'])
            ->make(true);
        }
        return view('admin.thiet_lap',[
            'user'=>$user,
            'vu_nuoi' => $lay_vu_nuoi,
            'khu_nuoi' => $lay_khu_nuoi,
            'ao_nuoi' => $lay_ao_nuoi,
            'vat_tu' => $lay_vat_tu,
        ]);
    }
    public function all_vu_nuoi(Request $request){
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','ASC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','ASC')->get();
        $lay_ao_nuoi = AoNuoi::orderBy('ma_ao','ASC')->get();
        $lay_vat_tu = VatTu::orderBy('ma_vat_tu','ASC')->get();
        $lay_vu = VuNuoi::query();
        $user = Auth::user();
        if($request->has('vu_lay_vu_loc') && $request->vu_lay_vu_loc != null){
            $lay_vu->where('ten_vu', $request->vu_lay_vu_loc);
        }
        if($request->ajax()){
            return DataTables::of($lay_vu)
            ->editColumn('trang_thai', function($lay_vu){
                if($lay_vu->trang_thai == 'Hoạt động'){
                    return '
                        <div>
                            <a href="/unactive-vu/'.$lay_vu->ma_vu.'">
                                <i class="fa fa-eye" aria-hidden="true" style="color: green; font-size: 20px;"></i>
                            </a>
                            Hoạt động
                        </div>
                    ';
                }elseif($lay_vu->trang_thai == 'Ngừng hoạt động'){
                    return '
                        <div>
                            <a href="/active-vu/'.$lay_vu->ma_vu.'">
                                <i class="fa fa-eye-slash" aria-hidden="true" style="color: red; font-size: 20px;"></i>
                            </a>
                            Ngừng hoạt động
                        </div>
                    ';
                }
            })
            ->editColumn('ngay_tao', function($row) {
                $date = Carbon::parse($row->ngay_tao)->format('d/m/Y');
                return $date;
            })
            ->editColumn('ngay_bat_dau', function($row) {
                $date = Carbon::parse($row->ngay_bat_dau)->format('d/m/Y');
                return $date;
            })
            ->editColumn('ngay_ket_thuc', function($row) {
                $date = Carbon::parse($row->ngay_ket_thuc)->format('d/m/Y');
                return $date;
            })
            ->addColumn('Action', function($lay_vu){
                $action ='
                <div class="dropdown">
                    <button class="dropbtn">Action</button>
                    <div class="dropdown-content">';
                    if(Gate::allows('edit.vu')){
                        $action .='
                        <a href="/edit-vu/'.$lay_vu->ma_vu.'">
                        Sửa vụ
                    </a>';
                    }
                    if(Gate::allows('delete.vu')){
                        $action .='
                        <a href="/delete-vu/'.$lay_vu->ma_vu.'">
                            Xóa vụ
                        </a>';
                    }
                    $action .='
                    </div>
                </div>
               ';
               return $action;
            } )->rawColumns(['Action','trang_thai'])
            ->make(true);
        }
        return view('admin.vu_nuoi.all_vu_nuoi',[
            'user'=>$user,
            'vu_nuoi' => $lay_vu_nuoi,
            'khu_nuoi' => $lay_khu_nuoi,
            'ao_nuoi' => $lay_ao_nuoi,
            'vat_tu' => $lay_vat_tu,
        ]);
    }
    public function save_vu_nuoi(Request $request){
        $this->authorize('add.vu');
        $data = $request->all();
        //dd($data);
        $vu= new VuNuoi();
        // $vu->ma_vu = $data['ma_vu'];
        $vu->ten_vu = $data['ten_vu'];
        $vu->ngay_bat_dau = $data['ngay_bat_dau'];
        $vu->ngay_ket_thuc = $data['ngay_ket_thuc'];
        // dd($data['ngay_bat_dau'] >= $data['ngay_ket_thuc']);
        $vu->ngay_tao = $data['ngay_tao'];
        $vu->trang_thai = 'Hoạt động';
        if(($data['ten_vu'] =='') || ($data['ngay_bat_dau'] =='') || ($data['ngay_ket_thuc'] =='')|| ($data['ngay_tao'] =='')){
            Session::put('error','Vui lòng nhập đầy đủ thông tin.');
            return Redirect::to('all-vu-nuoi');
        }
        //check ten vu da ton tai
        $check_vu = VuNuoi::get();
        foreach($check_vu as $check){
            if($data['ten_vu'] == $check->ten_vu){
                Session::put('error',''.$data['ten_vu'].' đã tồn tại.');
                return Redirect::to('all-vu-nuoi');
            }
        }
        if($data['ngay_tao'] > $data['ngay_bat_dau'] || $data['ngay_tao'] > $data['ngay_ket_thuc']){
            Session::put('error','Ngày tạo lớn hơn ngày bắt đầu hoặc ngày kết thúc.');
            return Redirect::to('all-vu-nuoi');
        }elseif($data['ngay_bat_dau'] >= $data['ngay_ket_thuc']){
            Session::put('error','Ngày bắt đầu lớn hơn ngày kết thúc.');
            return Redirect::to('all-vu-nuoi');
        }
        $vu->save();
        Session::put('message','Thêm vụ nuôi thành công.');
        return Redirect::to('all-vu-nuoi');
    }
    public function delete_vu($ma_vu){
        $this->authorize('delete.vu');
        $user = Auth::user();
        //dd($ma_khu);
        $check_vu_ao = VuNuoi::where('ma_vu',$ma_vu)->first();
        // dd($check_khu_cta);
        if($check_vu_ao){
            Session::put('error','Vụ này đang có ao nuôi, không thể xóa.');
            return Redirect::to('all-vu-nuoi');
        }
        VuNuoi::where('ma_vu',$ma_vu)->delete();
        Session::put('message','Xóa vụ nuôi thành công.');
        return Redirect::to('all-vu-nuoi');
    }
    public function edit_vu($ma_vu){
        $this->authorize('edit.vu');
        $user = Auth::user();
        $edit_vu = VuNuoi::where('ma_vu',$ma_vu)->get();
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','DESC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','DESC')->get();
        //dd($edit_ao);
        return view('admin.vu_nuoi.edit_vu_nuoi',[
            'vu_nuoi' => $lay_vu_nuoi,
            'khu_nuoi' => $lay_khu_nuoi,
            'edit_vu' => $edit_vu,
            'user' => $user,
        ]);
    }
    public function update_vu($ma_vu, Request $request){
        $this->authorize('edit.vu');
        $data = array();
        // $data['ma_vu']=$request->ma_vu;
        $data['ten_vu']=$request->ten_vu;
        $data['ngay_bat_dau']=$request->ngay_bat_dau;
        $data['ngay_ket_thuc']=$request->ngay_ket_thuc;
        $data['ngay_tao']=$request->ngay_tao;
        $data['trang_thai']=$request->trang_thai;
        $check_vu = VuNuoi::whereNot('ma_vu',$ma_vu)->get();
        //dd($check_khu);
        foreach($check_vu as $check){
            if($data['ten_vu'] == $check->ten_vu){
                Session::put('error','Vụ này đã tồn tại!!!.');
                return Redirect::to('all-vu-nuoi');
            }
        }
        VuNuoi::where('ma_vu',$ma_vu)->update($data);
        Session::put('message','Cập nhật vụ nuôi thành công.');
        return Redirect::to('all-vu-nuoi');
    }
    public function unactive_vu($ma_vu){
        VuNuoi::where('ma_vu',$ma_vu)->update([
            'trang_thai' => 'Ngừng hoạt động'
        ]);
        Session::put('message','Cập nhật trạng thái vụ nuôi thành công.');
        return redirect()->back();
    }
    public function active_vu($ma_vu){
        VuNuoi::where('ma_vu',$ma_vu)->update([
            'trang_thai' => 'Hoạt động'
        ]);
        Session::put('message','Cập nhật trạng thái vụ nuôi thành công.');
        return redirect()->back();
    }

}
