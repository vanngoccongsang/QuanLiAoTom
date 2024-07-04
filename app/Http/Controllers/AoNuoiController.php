<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AoNuoi;
use App\Models\ChiTietAo;
use App\Models\VuNuoi;
use App\Models\KhuNuoi;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\VatTu;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
class AoNuoiController extends Controller
{
    public function __construct()
    {
        // Apply middleware to all controller methods
        $this->middleware('auth.check');
    }
    // public function __construct()
    // {
    //     // Gán middleware 'auth' để đảm bảo người dùng đăng nhập.
    //     $this->middleware('auth');
    //     // Gán middleware 'can' để kiểm tra quyền truy cập cho các hành động cụ thể.
    //     $this->middleware('can:create-post', ['only' => ['create', 'store']]);
    //     $this->middleware('can:edit-post', ['only' => ['edit', 'update']]);
    //     $this->middleware('can:delete-post', ['only' => ['destroy']]);
    //     $this->middleware('role:admin', ['only' => ['create', 'edit', 'delete']]);
    // }
    public function all_ao_nuoi(Request $request){
        // $this->authorize('edit ao');
        // Role::create(['name' => 'publisher']);
        // Permission::create(['name' => 'delete ao']);
        // $role = Role::find(3);
        // $permission = Permission::find(4);
        // $role->givePermissionTo($permission);
        // if(auth()->user()){
        //     // auth()->user()->assignRole(['admin','editer','writer','publisher']);
        //     auth()->user()->givePermissionTo('add ao');
        // }

        $user = Auth::user();
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','ASC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','ASC')->get();
        $lay_vu_nuoi_add = VuNuoi::where('trang_thai','Hoạt động')->orderBy('ma_vu','ASC')->get();
        $lay_khu_nuoi_add = KhuNuoi::where('trang_thai','Hoạt động')->orderBy('ma_khu','ASC')->get();
        $lay_ao_nuoi = AoNuoi::orderBy('ma_ao','ASC')->get();
        //dd($lay_ao_nuoi);
        $lay_vat_tu = VatTu::orderBy('ma_vat_tu','ASC')->get();
        $max_ma_vu = AoNuoi::max('ma_vu');
        $lay_ao = AoNuoi::query()
        ->join('khu_nuoi', 'khu_nuoi.ma_khu','=','ao.ma_khu') // Joins the 'khu_nuoi' table with the 'ao' table on 'ma_khu' and 'ma_khu' respectively.
        ->join('vu_nuoi', 'vu_nuoi.ma_vu','=','ao.ma_vu')
        ->select('ao.*','khu_nuoi.ten_khu','vu_nuoi.ten_vu')->orderBy('ma_ao','ASC');
        if($request->has('lay_ao_loc') && $request->lay_ao_loc != null){
            $lay_ao->where('ao.ma_ao',$request->lay_ao_loc);
        }
        if($request->has('lay_khu_loc') && $request->lay_khu_loc != null){
            $lay_ao->where('ao.ma_khu',$request->lay_khu_loc);
        }
        if($request->has('lay_vu_loc') && $request->lay_vu_loc != null){
            $lay_ao->where('ao.ma_vu', $request->lay_vu_loc);
        }
        if($request->has('lay_trang_thai') && $request->lay_trang_thai != null){
            $lay_ao->where('ao.trang_thai', $request->lay_trang_thai);
        }
        //dd($lay_ao);
        if($request->ajax()){
            return DataTables::of($lay_ao)
            ->editColumn('ma_ao', function(){
                static $stt = 0;
                $stt++;
                return $stt;
            })
            ->editColumn('ten_khu', function($row){
                $lay_ten_khu = KhuNuoi::where('ma_khu',$row->ma_khu)->first();
                return $row->ten_khu;
            })
            ->editColumn('ten_vu', function($row){
                $lay_ten_vu = VuNuoi::where('ma_vu',$row->ma_vu)->first();
                return $row->ten_vu;
            })
            ->filterColumn('ten_khu', function($query, $keyword) {
                $sql = "CONCAT(khu_nuoi.ten_khu) LIKE ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('ten_vu', function($query, $keyword) {
                $sql = "CONCAT(vu_nuoi.ten_vu) LIKE ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->editColumn('dien_tich', '{{$dien_tich}} m²')
            ->editColumn('loi_nhuan', function($row) {
                if($row->loi_nhuan ==''){
                    return '';
                }
                $dt = number_format($row->loi_nhuan);
                return  $dt.' VND';
            })
            ->addColumn('ma_ao', function($row) {
                return  $row->ma_ao;
            })
            ->editColumn('trang_thai', function($row){
                if($row->trang_thai ==''){
                    return '<span class="label label-danger">Delivered</span>';
                }elseif($row->trang_thai =='Ngừng hoạt động'){
                    return '<span class="label label-danger">'.$row->trang_thai.'</span>';
                }elseif($row->trang_thai =='Hoạt động'){
                    return '<span class="label label-success">'.$row->trang_thai.'</span>';
                }elseif($row->trang_thai =='Đã bán'){
                    return '<span class="label label-info">'.$row->trang_thai.'</span>';
                }else
                return '<span class="label label-warning">'.$row->trang_thai.'</span>';
            })
            ->addColumn('Action_xem', function($row){
                if($row->trang_thai =='Đã bán'){
                    return'
                    <a href="/bao-cao-ao/'.$row->ma_ao.'/'.$row->ma_khu.'/'.$row->ma_vu.'">
                        Xem
                    </a>
                    <span> / </span>
                    <a href="/lich-su-nuoi/'.$row->ao_cha.'">
                        Lịch sử
                    </a>
                ';
                }else{
                    return'
                    <a href="/bao-cao-ao/'.$row->ma_ao.'/'.$row->ma_khu.'/'.$row->ma_vu.'">
                        Xem
                    </a>
                ';
                }
            })
            ->addColumn('Action', function($lay_ao){
                $action = '';
                if($lay_ao->trang_thai =='Hoạt động'){
                $action ='
                    <div style="display:flex; border:none;">
                    <div class="dropdown">
                    <button class="icon-dropdown">
                        <i class="fa fa-fw fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-content">';
                        // if(Gate::allows('add.chi.tiet.ao')){
                        //     $action .='
                        //     <a href="/add-chi-tiet-ao/'.$lay_ao->ma_ao.'">
                        //         Thêm chi tiết
                        //     </a>';
                        // }
                        if(Gate::allows('edit.ao')){
                            $action .='
                            <a href="/edit-ao/'.$lay_ao->ma_ao.'">
                                Sửa ao
                            </a>';
                        }
                $action .='
                        </div>
                    </div>
                    ';
                    if(Gate::allows('delete.ao')){
                        $action .='
                        <button type="button" class="" data-toggle="modal" data-target="#exampleModal'.$lay_ao->ma_ao.'" style="border: none;color:red;background-color: transparent; padding: 5px;">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal'.$lay_ao->ma_ao.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                <div class="modal-dialog" role="document">
                                <div class="modal-content" style="width: 75%;">
                                    <div class="modal-header" style="display:ruby-text;">
                                        <h4 class="modal-title" id="exampleModalLabel">
                                            <span style="margin-right: 10px;"class="glyphicon glyphicon-trash"></span> Xác nhận xóa
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn xóa ao nuôi không?
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a href="/delete-ao/'.$lay_ao->ma_ao.'">
                                        <button type="button" class="btn btn-danger">Xóa</button>
                                    </a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                }
               return $action;
            } )->rawColumns(['dien_tich','Action','doanh_thu','trang_thai','Action_xem','ma_ao','ten_khu','ten_vu'])
            ->make(true);
        }
        return view('admin.ao_nuoi.all_ao_nuoi',[
            'vu_nuoi' => $lay_vu_nuoi,
            'khu_nuoi' => $lay_khu_nuoi,
            'ao_nuoi' => $lay_ao_nuoi,
            'vat_tu' => $lay_vat_tu,
            'user'=> $user,
            'vu_nuoi_add' => $lay_vu_nuoi_add,
            'khu_nuoi_add' => $lay_khu_nuoi_add,
        ]);
    }
    public function save_ao_nuoi(Request $request){
        $this->authorize('add.ao');
        $data = $request->all();
        //dd($data);
        $ao = new AoNuoi();
        $ao->ten_ao = $data['ten_ao'];
        $ao->ma_khu = $data['ma_khu'];
        $ao->ma_vu = $data['ma_vu'];
        $ao->loai_ao = $data['loai_ao'];
        $ao->dien_tich = $data['dien_tich'];
        $ao->hinh_dang = $data['hinh_dang'];
        $ao->trang_thai = 'Hoạt động';
        // $ao->ao_cha = $data['ma_ao'];
        if(($data['ten_ao'] =='') || ($data['ma_khu'] =='') || ($data['ma_vu'] =='') ||
            ($data['loai_ao'] =='')|| ($data['dien_tich'] =='') || ($data['hinh_dang'] =='')){
            Session::put('error','Vui lòng nhập đầy đủ thông tin.');
            return Redirect::to('all-ao-nuoi');
        }
        $so_sanh = AoNuoi::get();
        foreach($so_sanh as $key => $ss){
            if(($ss->ten_ao == $data['ten_ao']) && ($ss->ma_khu == $data['ma_khu']) && ($ss->ma_vu == $data['ma_vu'])){
                Session::put('error','Ao, khu, vụ này đã tồn tại!!!.');
                return Redirect::to('all-ao-nuoi');
            }
            // elseif($ss->ten_ao == $data['ten_ao']){
            //     Session::put('error','Ao nuôi đã tồn tại');
            //     return Redirect::to('all-ao-nuoi');
            // }
        }
        $ao->save();
        Session::put('message','Thêm ao nuôi thành công.');
        return Redirect::to('all-ao-nuoi');
    }
    public function delete_ao($ma_ao){
        $this->authorize('delete.ao');
        $user = Auth::user();
        //dd($ma_ao);
        $check_ao_cta = ChiTietAo::where('ma_ao',$ma_ao)->first();
        // dd($check_khu_cta);
        if($check_ao_cta){
            Session::put('error','Ao này đã có lịch sử nuôi, không thể xóa.');
            return Redirect::to('all-ao-nuoi');
        }
        AoNuoi::where('ma_ao',$ma_ao)->delete();
        Session::put('message','Xóa ao nuôi thành công.');
        return redirect()->back();
    }
    public function edit_ao($ma_ao){
        $this->authorize('edit.ao');
        $user = Auth::user();
        $edit_ao = AoNuoi::where('ma_ao',$ma_ao)
        ->join('khu_nuoi', 'khu_nuoi.ma_khu','=','ao.ma_khu') // Joins the 'khu_nuoi' table with the 'ao' table on 'ma_khu' and 'ma_khu' respectively.
        ->join('vu_nuoi', 'vu_nuoi.ma_vu','=','ao.ma_vu') // Joins the 'vu_nuoi' table with the 'ao' table on 'ma_vu' and 'ma_vu' respectively.
        ->select('ao.*','khu_nuoi.ten_khu','vu_nuoi.ten_vu')
        ->get();
        //dd($edit_ao);
        $lay_vu_nuoi = VuNuoi::where('trang_thai','Hoạt động')->orderBy('ma_vu','ASC')->get();
        $lay_khu_nuoi = KhuNuoi::where('trang_thai','Hoạt động')->orderBy('ma_khu','ASC')->get();
        //dd($edit_ao);
        return view('admin.ao_nuoi.edit_ao_nuoi',[
            'user' => $user,
            'vu_nuoi' => $lay_vu_nuoi,
            'khu_nuoi' => $lay_khu_nuoi,
            'edit_ao' => $edit_ao
        ]);
    }
    public function update_ao($ma_ao, Request $request){
        $this->authorize('edit.ao');
        $data = array();
        // $data['ma_ao']=$request->ma_ao;
        $data['ten_ao'] = $request->ten_ao;
        $data['ma_khu'] = $request->ma_khu;
        $data['ma_vu'] = $request->ma_vu;
        $data['loai_ao'] = $request->loai_ao;
        $data['dien_tich'] = $request->dien_tich;
        $data['hinh_dang'] = $request->hinh_dang;
        $data['trang_thai'] = $request->trang_thai;
        $so_sanh = AoNuoi::whereNot('ma_ao', $ma_ao)->get();
        //dd($so_sanh);
        foreach($so_sanh as $key => $ss){
            if(($ss->ten_ao == $data['ten_ao']) && ($ss->ma_khu == $data['ma_khu']) && ($ss->ma_vu == $data['ma_vu'])){
                Session::put('error','Ao, khu, vụ này đã tồn tại!!!.');
                return Redirect::to('all-ao-nuoi');
            }
        }
        //thay doi khu vu cua ngay nuoi (chi tiet ao) sau khi thay doi khu vu cua ao nuoi do
        ChiTietAo::where('ma_ao',$ma_ao)->update([
            'ma_khu' => $data['ma_khu'],
            'ma_vu' => $data['ma_vu'],
        ]);
        AoNuoi::where('ma_ao',$ma_ao)->update($data);
        Session::put('message','Cập nhật ao nuôi thành công');
        return Redirect::to('all-ao-nuoi');
    }

}
