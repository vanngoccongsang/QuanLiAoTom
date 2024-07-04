<?php

namespace App\Http\Controllers;

use App\Models\KhuNuoi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Contracts\DataTable;
use Illuminate\Support\Facades\Auth;
use App\Models\VuNuoi;
use Yajra\DataTables\DataTables;
use App\Models\AoNuoi;
use App\Models\ChiTietAo;
use App\Models\VatTu;
use Illuminate\Support\Facades\Gate;
use App\Models\Location;
class KhuNuoiController extends Controller
{
    public function __construct()
    {
        // Apply middleware to all controller methods
        $this->middleware('auth.check');
    }
    public function all_khu_nuoi(Request $request){
        $user = Auth::user();
        $lay_all_location = Location::join('khu_nuoi','location.ma_khu','khu_nuoi.ma_khu')->get();
        $javascript_locations = [];
        foreach ($lay_all_location as $location) {
            $new_location = [
                "latitude" => $location["latitude"],
                "longitude" => $location["longitude"],
                "name" => $location["ten_khu"], // Sử dụng "ten_khu" thay vì "name"
                "dia_chi" => $location["dia_chi"] // Trường dia_chi sẽ luôn tồn tại
            ];
            $javascript_locations[] = $new_location;
        }
        //dd($lay_all_location);
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','ASC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','ASC')->get();
        $lay_ao_nuoi = AoNuoi::orderBy('ma_ao','ASC')->get();
        $lay_vat_tu = VatTu::orderBy('ma_vat_tu','ASC')->get();
        $lay_khu = KhuNuoi::query();
        if($request->has('khu_lay_khu_loc') && $request->khu_lay_khu_loc != null){
            $lay_khu->where('ten_khu',$request->khu_lay_khu_loc);
        }
        if($request->ajax()){

            return DataTables::of($lay_khu)
            ->editColumn('trang_thai', function($lay_khu){
                if($lay_khu->trang_thai == 'Hoạt động'){
                    return '
                        <div>
                            <a href="/unactive-khu/'.$lay_khu->ma_khu.'">
                                <i class="fa fa-eye" aria-hidden="true" style="color: green; font-size: 20px;"></i>
                            </a>
                            Hoạt động
                        </div>
                    ';
                }elseif($lay_khu->trang_thai == 'Ngừng hoạt động'){
                    return '
                        <div>
                            <a href="/active-khu/'.$lay_khu->ma_khu.'">
                                <i class="fa fa-eye-slash" aria-hidden="true" style="color: red; font-size: 20px;"></i>
                            </a>
                            Ngừng hoạt động
                        </div>
                    ';
                }
            })
            ->addColumn('Action', function($lay_khu){
                $action ='
                <div class="dropdown">
                    <button class="dropbtn">Action</button>
                    <div class="dropdown-content">';
                    if(Gate::allows('edit.khu')){
                        $action .='
                        <a href="/edit-khu/'.$lay_khu->ma_khu.'">
                            Sửa khu
                        </a>';
                    }
                    if(Gate::allows('delete.khu')){
                        $action .='
                        <a href="/delete-khu/'.$lay_khu->ma_khu.'">
                            Xóa khu
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
        return view('admin.khu_nuoi.all_khu_nuoi',[
            'vu_nuoi' => $lay_vu_nuoi,
            'khu_nuoi' => $lay_khu_nuoi,
            'ao_nuoi' => $lay_ao_nuoi,
            'vat_tu' => $lay_vat_tu,
            'user' => $user,
            'javascript_locations' => $javascript_locations,
        ]);
    }
    public function save_khu_nuoi(Request $request){
        $this->authorize('add.khu');
        $data = $request->all();
        //dd($data);
        $khu = new KhuNuoi();
        // $khu->ma_khu = $data['ma_khu'];
        $khu->ten_khu = $data['ten_khu'];
        $khu->dia_chi = $data['dia_chi'];
        $khu->trang_thai = 'Hoạt động';
        if(($data['ten_khu'] =='') || ($data['dia_chi'] =='')){
            Session::put('error','Vui lòng nhập đầy đủ thông tin!!!.');
            return Redirect::to('all-khu-nuoi');
        }
        $check_khu = KhuNuoi::get();
        foreach($check_khu as $check){
            if($data['ten_khu'] == $check->ten_khu){
                Session::put('error','Khu này đã tồn tại!!!.');
                return Redirect::to('all-khu-nuoi');
            }
        }
        $khu->save();
        Session::put('message','Thêm khu nuôi thành công.');
        return Redirect::to('all-khu-nuoi');
    }
    public function delete_khu($ma_khu){
        $this->authorize('delete.khu');
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','DESC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','DESC')->get();
        //dd($ma_khu);
        $check_khu_ao = AoNuoi::where('ma_khu',$ma_khu)->first();
        // dd($check_khu_cta);
        if($check_khu_ao){
            Session::put('error','Khu này đang có ao nuôi, không thể xóa.');
            return Redirect::to('all-khu-nuoi');
        }
        KhuNuoi::where('ma_khu',$ma_khu)->delete();
        Session::put('message','Xóa khu nuôi thành công.');
        return Redirect::to('all-khu-nuoi');
    }
    public function edit_khu($ma_khu){
        $this->authorize('edit.khu');
        $user = Auth::user();
        $edit_khu = KhuNuoi::where('ma_khu',$ma_khu)->get();
        //dd($edit_khu);
        return view('admin.khu_nuoi.edit_khu_nuoi',[
            'user' => $user,
            'edit_khu'=>$edit_khu
        ]);
    }
    public function update_khu($ma_khu, Request $request){
        $this->authorize('edit.khu');
        $data = array();
        $data['ten_khu']=$request->ten_khu;
        $data['dia_chi']=$request->dia_chi;
        $data['trang_thai']=$request->trang_thai;
        $check_khu = KhuNuoi::whereNot('ma_khu',$ma_khu)->get();
        //dd($check_khu);
        foreach($check_khu as $check){
            if($data['ten_khu'] == $check->ten_khu){
                Session::put('error','Khu này đã tồn tại!!!.');
                return Redirect::to('all-khu-nuoi');
            }
        }
        KhuNuoi::where('ma_khu',$ma_khu)->update($data);
        Session::put('message','Cập nhật khu nuôi thành công.');
        return Redirect::to('all-khu-nuoi');
    }
    public function unactive_khu($ma_khu){
        KhuNuoi::where('ma_khu',$ma_khu)->update([
            'trang_thai' => 'Ngừng hoạt động'
        ]);
        Session::put('message','Cập nhật trạng thái khu nuôi thành công.');
        return redirect()->back();
    }
    public function active_khu($ma_khu){
        KhuNuoi::where('ma_khu',$ma_khu)->update([
            'trang_thai' => 'Hoạt động'
        ]);
        Session::put('message','Cập nhật trạng thái khu nuôi thành công.');
        return redirect()->back();
    }
}
