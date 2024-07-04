<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KhuNuoi;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Contracts\DataTable;
use Illuminate\Support\Facades\Auth;
use App\Models\VuNuoi;
use Yajra\DataTables\DataTables;
use App\Models\AoNuoi;
use App\Models\KhachHang;
use App\Models\VatTu;
use Illuminate\Support\Facades\Gate;

class KhachHangController extends Controller
{
    public function __construct()
    {
        // Apply middleware to all controller methods
        $this->middleware('auth.check');
    }
    public function all_khach_hang(Request $request){
        $user = Auth::user();
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','ASC')->get();
        $khach_hang = KhachHang::orderBy('id_khach_hang','ASC')->get();
        $lay_ao_nuoi = AoNuoi::orderBy('ma_ao','ASC')->get();
        $lay_vat_tu = VatTu::orderBy('ma_vat_tu','ASC')->get();
        $lay_khach_hang = KhachHang::query();
        if($request->has('kh_lay_loai_loc') && $request->kh_lay_loai_loc != null){
            $lay_khach_hang->where('loai_khach_hang',$request->kh_lay_loai_loc);
        }
        if($request->has('kh_lay_ten_loc') && $request->kh_lay_ten_loc != null){
            $lay_khach_hang->where('ten_khach_hang',$request->kh_lay_ten_loc);
        }
        if($request->ajax()){
            return DataTables::of($lay_khach_hang)
            // ->editColumn('trang_thai', function($row){
            //     if($lay_khu->trang_thai == 'Hoạt động'){
            //         return '
            //             <div>
            //                 <a href="/unactive-khu/'.$lay_khu->ma_khu.'">
            //                     <i class="fa fa-eye" aria-hidden="true" style="color: green; font-size: 20px;"></i>
            //                 </a>
            //                 Hoạt động
            //             </div>
            //         ';
            //     }elseif($lay_khu->trang_thai == 'Ngừng hoạt động'){
            //         return '
            //             <div>
            //                 <a href="/active-khu/'.$lay_khu->ma_khu.'">
            //                     <i class="fa fa-eye-slash" aria-hidden="true" style="color: red; font-size: 20px;"></i>
            //                 </a>
            //                 Ngừng hoạt động
            //             </div>
            //         ';
            //     }
            // })
            ->editColumn('ten_khach_hang', function($row){
                $check_da_mua = AoNuoi::where('id_khach_hang',$row->id_khach_hang)->first();
                if($check_da_mua){
                    return '<span class="label label-warning" style="font-size: 13px;">'.$row->ten_khach_hang.'</span>';
                }else{
                    return $row->ten_khach_hang;
                }
            })
            ->addColumn('Action', function($row){
                $action ='
                <div class="dropdown">
                    <button class="dropbtn">Action</button>
                    <div class="dropdown-content">';
                    if(Gate::allows('edit.khach.hang')){
                        $action .='
                        <a href="/edit-khach-hang/'.$row->id_khach_hang.'">
                            Sửa
                        </a>';
                    }
                    if(Gate::allows('delete.khach.hang')){
                        $action .='
                        <a href="/delete-khach-hang/'.$row->id_khach_hang.'">
                            Xóa
                        </a>';
                    }
                    $action .='
                    </div>
                </div>
               ';
               return $action;
            } )->rawColumns(['Action','trang_thai','ten_khach_hang'])
            ->make(true);
        }
        return view('admin.khach_hang.all_khach_hang',compact('khach_hang','user'));
    }
    public function save_khach_hang(Request $request){
        $this->authorize('add.khach.hang');
        $data = $request->all();
        //dd($data);
        $khach_hang = new KhachHang();
        $khach_hang->loai_khach_hang = $data['loai_khach_hang'];
        $khach_hang->ten_khach_hang = $data['ten_khach_hang'];
        $khach_hang->so_dien_thoai = $data['so_dien_thoai'];
        $khach_hang->dia_chi = $data['dia_chi'];
        $khach_hang->ghi_chu = $data['ghi_chu'];
        if(($data['ten_khach_hang'] =='') || ($data['so_dien_thoai'] =='') || ($data['dia_chi'] =='' )){
            Session::put('error','Vui lòng nhập đầy đủ thông tin!!!.');
            return Redirect::to('all-khach-hang');
        }
        $khach_hang->save();
        Session::put('message','Thêm khách hàng thành công.');
        return Redirect::to('all-khach-hang');
    }
    public function delete_khach_hang($id_khach_hang){
        $this->authorize('delete.khach.hang');
        $check_da_mua = AoNuoi::where('id_khach_hang',$id_khach_hang)->first();
        if($check_da_mua){
            Session::put('error','Khách hàng đã mua, không thể xóa.');
            return Redirect::to('all-khach-hang');
        }
        KhachHang::where('id_khach_hang',$id_khach_hang)->delete();
        Session::put('message','Xóa khách hàng thành công.');
        return Redirect::to('all-khach-hang');
    }
    public function edit_khach_hang($id_khach_hang){
        $this->authorize('edit.khach.hang');
        $user = Auth::user();
        $edit_khach_hang = KhachHang::where('id_khach_hang',$id_khach_hang)->get();
        //dd($edit_khu);
        return view('admin.khach_hang.edit_khach_hang',[
            'user' => $user,
            'edit_khach_hang'=>$edit_khach_hang
        ]);
    }
    public function update_khach_hang($id_khach_hang, Request $request){
        $this->authorize('edit.khach.hang');
        $data = array();
        $data['loai_khach_hang'] = $request->loai_khach_hang;
        $data['ten_khach_hang'] = $request->ten_khach_hang;
        $data['so_dien_thoai'] = $request->so_dien_thoai;
        $data['dia_chi'] = $request->dia_chi;
        $data['ghi_chu'] = $request->ghi_chu;
        if($data['loai_khach_hang']=='' || $data['ten_khach_hang']=='' || $data['so_dien_thoai']=='' || $data['dia_chi']==''){
            Session::put('error','Vui lòng nhập đầy đủ thông tin!!!.');
            return Redirect::to('all-khach-hang');
        }
        KhachHang::where('id_khach_hang',$id_khach_hang)->update($data);
        Session::put('message','Cập nhật khách hàng thành công.');
        return Redirect::to('all-khach-hang');
    }
    // public function unactive_khu($ma_khu){
    //     KhuNuoi::where('ma_khu',$ma_khu)->update([
    //         'trang_thai' => 'Ngừng hoạt động'
    //     ]);
    //     Session::put('message','Cập nhật trạng thái khu nuôi thành công');
    //     return redirect()->back();
    // }
    // public function active_khu($ma_khu){
    //     KhuNuoi::where('ma_khu',$ma_khu)->update([
    //         'trang_thai' => 'Hoạt động'
    //     ]);
    //     Session::put('message','Cập nhật trạng thái khu nuôi thành công');
    //     return redirect()->back();
    // }
}
