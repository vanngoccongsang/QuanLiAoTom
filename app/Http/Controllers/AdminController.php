<?php

namespace App\Http\Controllers;

use App\Models\AoNuoi;
use Illuminate\Http\Request;
use App\Models\VuNuoi;
use App\Models\KhuNuoi;
use App\Models\NhatKy;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use App\Models\ChiTietAo;
use App\Models\GiaTom;
use App\Models\KhachHang;
use App\Models\MoiTruong;
use Illuminate\Support\Facades\App;
use App\Models\User;
use App\Models\VatTu;
use Dompdf\Dompdf;
use DateTime;
use Dompdf\Options;
use App\Models\Location;

use Illuminate\Support\Facades\Redirect;

use function GuzzleHttp\json_encode;

class AdminController extends Controller
{
    public function __construct()
    {
        // Apply middleware to all controller methods
        $this->middleware('auth.check');
        //ngoai tru in lich su nuoi
        // $this->middleware('auth.check')->except(['xuat_lich_su_nuoi']);
    }
    public function trang_chu(){
        $user = Auth::user();
        $lay_ds_ao = AoNuoi::join('khu_nuoi','khu_nuoi.ma_khu','=','ao.ma_khu')
        ->join('vu_nuoi','vu_nuoi.ma_vu','=','ao.ma_vu')->orderBy('ma_ao','ASC')
        ->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
        //dd($lay_ds_ao);
        $lay_ao = AoNuoi::orderBy('ma_ao','ASC')->get();
        if(isset($_GET['sort_tt'])){
            $sort_tt = $_GET['sort_tt'];
            if($sort_tt =='ngung_hoat_dong'){
                $lay_ds_ao = AoNuoi::join('khu_nuoi','khu_nuoi.ma_khu','=','ao.ma_khu')->join('vu_nuoi','vu_nuoi.ma_vu','=','ao.ma_vu')->orderBy('ma_ao','ASC')
                ->where('ao.trang_thai','Ngừng hoạt động')->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
            }elseif($sort_tt =='hoat_dong'){
                $lay_ds_ao = AoNuoi::join('khu_nuoi','khu_nuoi.ma_khu','=','ao.ma_khu')->join('vu_nuoi','vu_nuoi.ma_vu','=','ao.ma_vu')->orderBy('ma_ao','ASC')
                ->where('ao.trang_thai','Hoạt động')->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
            }elseif($sort_tt =='da_ban'){
                $lay_ds_ao = AoNuoi::join('khu_nuoi','khu_nuoi.ma_khu','=','ao.ma_khu')->join('vu_nuoi','vu_nuoi.ma_vu','=','ao.ma_vu')->orderBy('ma_ao','ASC')
                ->where('ao.trang_thai','Đã bán')->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
            }elseif($sort_tt =='tat_ca_ao'){
                $lay_ds_ao;
            }
        }
        $lay_ao_sort = AoNuoi::orderBy('ma_ao','ASC')->get();
        foreach($lay_ao_sort as $val){
            if(isset($_GET['sort_ao'])){
                $sort_ao = $_GET['sort_ao'];
                if($sort_ao == $val->ma_ao){
                    $lay_ds_ao = AoNuoi::join('khu_nuoi','khu_nuoi.ma_khu','=','ao.ma_khu')->join('vu_nuoi','vu_nuoi.ma_vu','=','ao.ma_vu')->orderBy('ma_ao','ASC')
                ->where('ao.ma_ao', $val->ma_ao)->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
                }elseif($sort_ao == 'tat_ca_ao'){
                    $lay_ds_ao;
                }
            }
        }
        $lay_khu_sort = KhuNuoi::orderBy('ma_khu','ASC')->get();
        foreach($lay_khu_sort as $val){
            if(isset($_GET['sort_khu'])){
                $sort_khu = $_GET['sort_khu'];
                if($sort_khu == $val->ma_khu){
                    $lay_ds_ao = AoNuoi::join('khu_nuoi','khu_nuoi.ma_khu','=','ao.ma_khu')->join('vu_nuoi','vu_nuoi.ma_vu','=','ao.ma_vu')->orderBy('ma_ao','ASC')
                    ->where('ao.ma_khu',$val->ma_khu)->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
                }elseif($sort_khu =='tat_ca_ao'){
                    $lay_ds_ao;
                }
            }
        }
        $lay_vu_sort = VuNuoi::orderBy('ma_vu','ASC')->get();
        foreach($lay_vu_sort as $val){
            if(isset($_GET['sort_vu'])){
                $sort_vu = $_GET['sort_vu'];
                if($sort_vu == $val->ma_vu){
                    $lay_ds_ao = AoNuoi::join('khu_nuoi','khu_nuoi.ma_khu','=','ao.ma_khu')->join('vu_nuoi','vu_nuoi.ma_vu','=','ao.ma_vu')->orderBy('ma_ao','ASC')
                    ->where('ao.ma_vu',$val->ma_vu)->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
                }elseif($sort_vu =='tat_ca_ao'){
                    $lay_ds_ao;
                }
            }
        }
        // foreach($lay_ao as $ao){
        //     $check_hien_lich_su = $ao->trang_thai;
        // }
        $count_vu_nuoi = VuNuoi::count();
        $count_khu_nuoi = KhuNuoi::count();
        $count_ao_nuoi = AoNuoi::count();
        $count_vat_tu = VatTu::count();
        //tong chi phi mua vat tu
        $chi_phi_vat_tu = 0;
        $lay_vt = VatTu::orderBy('ma_vat_tu','ASC')->get();
        foreach($lay_vt as $key => $val){
            $ten_vat_tu_Data[] = $val->ten_vat_tu;
            $so_luong_nhap_Data[] =  $val->so_luong_nhap;
            $so_luong_ton_Data[] =  $val->so_luong_ton;
            $gia_Data[] = $val->gia_vat_tu;
            $chi_phi_vat_tu += $val->gia_vat_tu;
        }
        $bar_ten_vat_tu = json_encode($ten_vat_tu_Data);
        $bar_so_luong_nhap = json_encode($so_luong_nhap_Data);
        $bar_so_luong_ton = json_encode($so_luong_ton_Data);
        $bar_gia_vat_tu = json_encode($gia_Data);
        //tinh tong so luong cua ngay hien tai
        $currentDateTime = Carbon::now('Asia/Ho_Chi_Minh')->startOfDay();
        $lay_chi_tiet = ChiTietAo::whereDate('ngay',$currentDateTime)->get();
        //dd($lay_chi_tiet);
        $tong_thuc_an = 0;
        $tong_luong_tom = 0;
        foreach($lay_chi_tiet as $key => $value){
            $tong_thuc_an += $value->luong_thuc_an;
            $tong_luong_tom += $value->luong_tom_giong;
        }
        //dd($tong_thuc_an, $tong_luong_tom );
        $ten_ao_Data[] = '';
        $loi_nhuan_Data[] = '';
        $loi_nhuan = AoNuoi::where('loi_nhuan','!=',null)->orderBy('ma_ao','ASC')->get();
            foreach($loi_nhuan as $key => $val){
                $ten_ao_Data[] = $val->ten_ao;
                $loi_nhuan_Data[] = $val->loi_nhuan;
            }
        //gia tom
        $gia_tom = GiaTom::orderBy('ngay_ban','ASC')->get();
        foreach($gia_tom as $key => $val){
            $date = Carbon::parse($val->ngay_ban)->format('d-m-Y');
            $ngay_ban_Data[] = $date;
            $gia_ban_Data[] = $val->gia_ban;
            // $formattedGiaBan = number_format($val->gia_ban, 2, '.', ','); // Format to 2 decimal places
            // $gia_ban_Data[] = $formattedGiaBan; // Add formatted value to the array
        }
        $lay_gia_tom = GiaTom::latest('ngay_ban')->first();
        $new_gia_tom = $lay_gia_tom->gia_ban;
        return view('admin.trang_chu',[
            'user' => $user,
            'lay_ao' => $lay_ao,
            'lay_ds_ao' => $lay_ds_ao,
            // 'ten_vu' => $ten_vu,
            'count_khu' => $count_khu_nuoi,
            'count_vu' => $count_vu_nuoi,
            'count_ao' => $count_ao_nuoi,
            'count_vat_tu' => $count_vat_tu,
            'new_gia_tom' => $new_gia_tom,
            'bar_ten_vat_tu' => $bar_ten_vat_tu,
            'bar_so_luong_nhap' => $bar_so_luong_nhap,
            'bar_so_luong_ton' => $bar_so_luong_ton,
            'bar_gia_vat_tu' => $bar_gia_vat_tu,
            'tong_thuc_an' => $tong_thuc_an,
            'tong_luong_tom' => $tong_luong_tom,
            'chi_phi_vat_tu' => $chi_phi_vat_tu,
            'ten_ao' => json_encode($ten_ao_Data),
            'loi_nhuan' => json_encode($loi_nhuan_Data),
            'ngay_ban' => json_encode($ngay_ban_Data),
            'gia_ban' => json_encode($gia_ban_Data),
            // 'check_hien_lich_su' => $check_hien_lich_su,
            'lay_ao_sort' => $lay_ao_sort,
            'lay_khu_sort' => $lay_khu_sort,
            'lay_vu_sort' => $lay_vu_sort,

            ]);
    }
    public function back(){
        return redirect()->back();
    }
    public function ban_tom(){
        $user = Auth::user();
        $lay_ds_ao = AoNuoi::join('khu_nuoi','khu_nuoi.ma_khu','=','ao.ma_khu')
        ->join('vu_nuoi','vu_nuoi.ma_vu','=','ao.ma_vu')
        ->whereNot('ao.trang_thai','Đã bán')->orderBy('ma_ao','ASC')
        ->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
        //dd($lay_ds_ao);
        $lay_ao = AoNuoi::orderBy('ma_ao','ASC')->get();
        if(isset($_GET['sort_tt'])){
            $sort_tt = $_GET['sort_tt'];
            if($sort_tt =='ngung_hoat_dong'){
                $lay_ds_ao = AoNuoi::join('khu_nuoi','khu_nuoi.ma_khu','=','ao.ma_khu')->join('vu_nuoi','vu_nuoi.ma_vu','=','ao.ma_vu')->orderBy('ma_ao','ASC')
                ->where('ao.trang_thai','Ngừng hoạt động')->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
            }elseif($sort_tt =='hoat_dong'){
                $lay_ds_ao = AoNuoi::join('khu_nuoi','khu_nuoi.ma_khu','=','ao.ma_khu')->join('vu_nuoi','vu_nuoi.ma_vu','=','ao.ma_vu')->orderBy('ma_ao','ASC')
                ->where('ao.trang_thai','Hoạt động')->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
            }elseif($sort_tt =='da_ban'){
                $lay_ds_ao = AoNuoi::join('khu_nuoi','khu_nuoi.ma_khu','=','ao.ma_khu')->join('vu_nuoi','vu_nuoi.ma_vu','=','ao.ma_vu')->orderBy('ma_ao','ASC')
                ->where('ao.trang_thai','Đã bán')->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
            }elseif($sort_tt =='tat_ca_ao'){
                $lay_ds_ao;
            }
        }
        $lay_ao_sort = AoNuoi::orderBy('ma_ao','ASC')->get();
        foreach($lay_ao_sort as $val){
            if(isset($_GET['sort_ao'])){
                $sort_ao = $_GET['sort_ao'];
                if($sort_ao == $val->ma_ao){
                    $lay_ds_ao = AoNuoi::join('khu_nuoi','khu_nuoi.ma_khu','=','ao.ma_khu')->join('vu_nuoi','vu_nuoi.ma_vu','=','ao.ma_vu')->orderBy('ma_ao','ASC')
                ->where('ao.ma_ao', $val->ma_ao)->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
                }elseif($sort_ao == 'tat_ca_ao'){
                    $lay_ds_ao;
                }
            }
        }
        $lay_khu_sort = KhuNuoi::orderBy('ma_khu','ASC')->get();
        foreach($lay_khu_sort as $val){
            if(isset($_GET['sort_khu'])){
                $sort_khu = $_GET['sort_khu'];
                if($sort_khu == $val->ma_khu){
                    $lay_ds_ao = AoNuoi::join('khu_nuoi','khu_nuoi.ma_khu','=','ao.ma_khu')->join('vu_nuoi','vu_nuoi.ma_vu','=','ao.ma_vu')->orderBy('ma_ao','ASC')
                    ->where('ao.ma_khu',$val->ma_khu)->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
                }elseif($sort_khu =='tat_ca_ao'){
                    $lay_ds_ao;
                }
            }
        }
        $lay_vu_sort = VuNuoi::orderBy('ma_vu','ASC')->get();
        foreach($lay_vu_sort as $val){
            if(isset($_GET['sort_vu'])){
                $sort_vu = $_GET['sort_vu'];
                if($sort_vu == $val->ma_vu){
                    $lay_ds_ao = AoNuoi::join('khu_nuoi','khu_nuoi.ma_khu','=','ao.ma_khu')->join('vu_nuoi','vu_nuoi.ma_vu','=','ao.ma_vu')->orderBy('ma_ao','ASC')
                    ->where('ao.ma_vu',$val->ma_vu)->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
                }elseif($sort_vu =='tat_ca_ao'){
                    $lay_ds_ao;
                }
            }
        }
        return view('admin.ban_tom.ban_tom',compact('user','lay_ds_ao','lay_ao_sort','lay_khu_sort','lay_vu_sort'));
    }
    public function loc_bo_loc(Request $request) {
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','ASC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','ASC')->get();
        $lay_ao_nuoi = AoNuoi::orderBy('ma_ao','ASC')->select('ma_ao','ten_ao')->get();

        //Chi chon 1 bo loc
        if($request->has('lay_khu_loc') && $request->lay_khu_loc != null){
            $lay_ao_nuoi = AoNuoi::where('ma_khu',$request->lay_khu_loc)->select('ma_ao','ten_ao')->orderBy('ma_ao','ASC')->get();
        }elseif($request->has('lay_vu_loc') && $request->lay_vu_loc != null){
            $lay_ao_nuoi = AoNuoi::where('ma_vu', $request->lay_vu_loc)->select('ma_ao','ten_ao')->orderBy('ma_vu','ASC')->get();
        }elseif($request->has('lay_trang_thai') && $request->lay_trang_thai != null){
            $lay_ao_nuoi = AoNuoi::where('trang_thai', $request->lay_trang_thai)->select('ma_ao','ten_ao')->orderBy('ma_vu','ASC')->get();
        }
        //chon 2 bo loc
        if($request->has('lay_khu_loc') && $request->lay_khu_loc != null && $request->has('lay_vu_loc') && $request->lay_vu_loc != null){
            $lay_ao_nuoi = AoNuoi::where('ma_khu',$request->lay_khu_loc)->
            where('ma_vu', $request->lay_vu_loc)->orderBy('ma_ao','ASC')->select('ma_ao','ten_ao')->get();
        }elseif($request->has('lay_vu_loc') && $request->lay_vu_loc != null && $request->has('lay_trang_thai') && $request->lay_trang_thai != null){
            $lay_ao_nuoi = AoNuoi::where('trang_thai',$request->lay_trang_thai)
            ->where('ma_vu', $request->lay_vu_loc)->orderBy('ma_ao','ASC')->select('ma_ao','ten_ao')->get();
        }elseif($request->has('lay_khu_loc') && $request->lay_khu_loc != null && $request->has('lay_trang_thai') && $request->lay_trang_thai != null){
            $lay_ao_nuoi = AoNuoi::where('trang_thai',$request->lay_trang_thai)
            ->where('ma_khu', $request->lay_khu_loc)->select('ma_ao','ten_ao')->orderBy('ma_ao','ASC')->get();
        }
        //chon 3 bo loc
        if($request->has('lay_khu_loc') && $request->lay_khu_loc != null && $request->has('lay_vu_loc') && $request->lay_vu_loc != null && $request->has('lay_trang_thai') && $request->lay_trang_thai != null){
            $lay_ao_nuoi = AoNuoi::
            where('trang_thai',$request->lay_trang_thai)
            ->where('ma_khu', $request->lay_khu_loc)
            ->where('ma_vu', $request->lay_vu_loc)
            ->select('ma_ao','ten_ao')->orderBy('ma_ao','ASC')->get();
        }
        return response()->json([
            'json_lay_ao_nuoi' => $lay_ao_nuoi,
            // 'json_lay_khu_nuoi' => $lay_khu_nuoi,
        ]);
    }
    //chi tiet ao
    public function chi_tiet_ao(Request $request){
        $user = Auth::user();
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','ASC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','ASC')->get();
        $lay_ao_nuoi = AoNuoi::orderBy('ma_ao','ASC')->select('ma_ao','ten_ao')->get();
        $lay_chi_tiet = ChiTietAo::query();
        if($request->ajax()){
            if($request->has('lay_ao_loc') && $request->lay_ao_loc != null){
                $lay_chi_tiet->where('ma_ao', $request->lay_ao_loc);
            }
            if($request->has('lay_khu_loc') && $request->lay_khu_loc != null){
                $lay_chi_tiet->where('ma_khu',$request->lay_khu_loc);
            }
            if($request->has('lay_vu_loc') && $request->lay_vu_loc != null){
                $lay_chi_tiet->where('ma_vu', $request->lay_vu_loc);
            }
            return DataTables::of($lay_chi_tiet)
            ->addColumn('TT', function($row){
                $ten_ao = AoNuoi::where('ma_ao',$row->ma_ao)->first();
                $ten_khu = KhuNuoi::where('ma_khu',$row->ma_khu)->first();
                $ten_vu = VuNuoi::where('ma_vu',$row->ma_vu)->first();
                if($ten_ao){
                    return
                        '<p style="color: rgb(246, 113, 113); font-size:14px; width:150px;">
                            '.$ten_ao->ten_ao .' - '. $ten_khu->ten_khu.' - '. $ten_vu->ten_vu.'
                        </p>';
                }
                return'';
            })
            ->editColumn('ngay', function($row) {
                $date = Carbon::parse($row->ngay)->format('d/m/Y');
                return $date;
            })
            ->editColumn('luong_thuc_an', '{{$luong_thuc_an}} kg')
            ->editColumn('luong_tom_sp', function($row) {
                if($row->luong_tom_sp =='' || $row->luong_tom_sp == 0){
                    return '';
                }
                return number_format($row->luong_tom_sp).' gram';
            })
            ->editColumn('luong_tom_giong', function($row) {
                if($row->luong_tom_giong =='' || $row->luong_tom_giong == 0){
                    return '';
                }
                return number_format($row->luong_tom_giong).' con';
            })
            ->editColumn('hao_hut', function($row) {
                if($row->hao_hut ==''){
                    return '';
                }
                return number_format($row->hao_hut).' con';
            })
            ->editColumn('sl_nhan_chiet', function($row) {
                if($row->sl_nhan_chiet ==''){
                    return '';
                }
                return number_format($row->sl_nhan_chiet).' con';
            })
            ->editColumn('tinh_trang', function($row) {
                if($row->tinh_trang ==''){
                    return '';
                }
                return  '<p style="font-size:14px; width:100px;">
                            '.$row->tinh_trang.'
                        </p>';
            })
            ->addColumn('Action', function($row){
                return'
                <div class="dropdown">
                    <button class="dropbtn">Action</button>
                    <div class="dropdown-content">
                        <a href="/edit-chi-tiet-ao/'.$row->id_chi_tiet_ao.'">
                            Sửa
                        </a>
                        <a href="/delete-chi-tiet-ao/'.$row->id_chi_tiet_ao.'">
                            Xóa
                        </a>
                    </div>
                </div>
               ';
            } )->rawColumns(['TT','ngay','ADG','FCR','size','hao_hut', 'tinh_trang', 'Action','sl_nhan_chiet'])
            ->make(true);
        }
        // $responseData = json_encode(['json_lay_ao_nuoi' => $lay_ao_nuoi]);
        // dd($lay_ao_nuoi, $responseData);
        return view('chi_tiet_ao_nuoi.chi_tiet_ao',[
            'lay_vu_nuoi' => $lay_vu_nuoi,
            'lay_khu_nuoi' => $lay_khu_nuoi,
            'lay_ao_nuoi' => $lay_ao_nuoi,
            'user' => $user,
        ]);
    }
    public function add_chi_tiet_ao($ma_ao){
        $this->authorize('add.chi.tiet.ao');
        $user = Auth::user();
        $save_nk = AoNuoi::where('ma_ao',$ma_ao)->first();
        //dd($save_nk->ma_khu);
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','DESC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','DESC')->get();

        //dd($edit_ao);

        return view('admin.add.add_chi_tiet_ao',[
            'vu_nuoi' => $lay_vu_nuoi,
            'khu_nuoi' => $lay_khu_nuoi,
            'save_nk' => $save_nk,
            'user' => $user,
        ] );
    }
    public function save_chi_tiet_ao(Request $request){
        $user = Auth::user();
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','DESC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','DESC')->get();
        $lay_ao_nuoi = AoNuoi::orderBy('ma_ao','DESC')->get();
        $data = $request->all();
        //dd($data);
        $nhat_ky = new ChiTietAo();
        $nhat_ky->ma_ao = $data['lay_ma_ao'];
        $nhat_ky->ma_khu = $data['lay_ma_khu'];
        $nhat_ky->ma_vu = $data['lay_ma_vu'];
        $nhat_ky->ngay = $data['ngay'];
       // dd( $nhat_ky->ngay);
        $nhat_ky->tuoi_tom = $data['tuoi_tom'];
        // $nhat_ky->luong_thuc_an = $data['luong_thuc_an'];
        $nhat_ky->luong_tom_giong = $data['luong_tom_giong'];
        $nhat_ky->luong_tom_sp = $data['luong_tom_sp'];
        // $nhat_ky->ADG = $data['ADG'];
        // $nhat_ky->FCR = $data['FCR'];

        $nhat_ky->size = $data['size'];
        // $nhat_ky->hao_hut = $data['hao_hut'];
        // $nhat_ky->tinh_trang = $data['tinh_trang'];
        if( $data['ngay'] == null || $data['tuoi_tom'] == null || $data['luong_tom_sp']== null){
            Session::put('error','Hãy điền đầy đủ ngày nuôi, tuổi, lượng tôm si phong!!!.');
                return redirect()->back();
        }
        $so_sanh = ChiTietAo::get();
        foreach($so_sanh as $ss){
            if((($ss->ma_ao == $data['lay_ma_ao']) && ($ss->ngay == $data['ngay'])) || (($ss->ma_ao == $data['lay_ma_ao']) && ($ss->tuoi_tom == $data['tuoi_tom']))){
                //return 1;
                Session::put('error','Ngày nuôi hoặc tuổi đã tồn tại.');
                return redirect()->back();
            }
        }
        //dd($so_sanh);
        $nhat_ky->save();
        Session::put('message','Thêm nhật ký nuôi thành công');
        return redirect()->back()->with([
            'vu_nuoi' => $lay_vu_nuoi,
            'khu_nuoi' => $lay_khu_nuoi,
            'ao_nuoi' => $lay_ao_nuoi,
            'user' => $user
        ]);
    }
    public function edit_chi_tiet_ao($id_chi_tiet_ao){
        $user = Auth::user();
        $ten_ao = ChiTietAo::where('id_chi_tiet_ao',$id_chi_tiet_ao)
        ->join('ao','ao.ma_ao','chi_tiet_ao.ma_ao')
        ->join('khu_nuoi', 'khu_nuoi.ma_khu','=','ao.ma_khu') // Joins the 'khu_nuoi' table with the 'ao' table on 'ma_khu' and 'ma_khu' respectively.
        ->join('vu_nuoi', 'vu_nuoi.ma_vu','=','ao.ma_vu') // Joins the 'vu_nuoi' table with the 'ao' table on 'ma_vu' and 'ma_vu' respectively.
        ->get();
        //dd($ten_ao);
        $edit_chi_tiet_ao = ChiTietAo::where('id_chi_tiet_ao',$id_chi_tiet_ao)->get();
        $lay_vu_nuoi = VuNuoi::orderBy('ma_vu','DESC')->get();
        $lay_khu_nuoi = KhuNuoi::orderBy('ma_khu','DESC')->get();
        //dd($edit_ao);
        return view('chi_tiet_ao_nuoi.edit_chi_tiet_ao',[
            'vu_nuoi' => $lay_vu_nuoi,
            'khu_nuoi' => $lay_khu_nuoi,
            'ten_ao' => $ten_ao,
            'edit_chi_tiet_ao' => $edit_chi_tiet_ao,
            'user' => $user,
        ]);
    }
    public function update_chi_tiet_ao($id_chi_tiet_ao, Request $request){
        $data = array();
        $data['ma_ao'] = $request->ma_ao;
        $data['ngay'] = $request->ngay;
        //dd(  $data['ngay']);
        $data['tuoi_tom'] = $request->tuoi_tom;
        // $data['luong_thuc_an']=$request->luong_thuc_an;
        $data['luong_tom_giong'] = $request->luong_tom_giong;
        $data['luong_tom_sp'] = $request->luong_tom_sp;
        // $data['ADG']=$request->ADG;
        // $data['FCR']=$request->FCR;
        $data['size'] = $request->size;
        // $data['hao_hut']=$request->hao_hut;
        // $data['tinh_trang']=$request->tinh_trang;
        $check_ct = ChiTietAo::where('ma_ao',$data['ma_ao'])->get();
        //dd($check_ct);
        // foreach( $check_ct as $check){
        //     if($data['ngay'] == $check->ngay){
        //         Session::put('message','Ngày nuôi đã tồn tại !!!.');
        //         return redirect()->back();
        //     }
        // }
        $id_back = ChiTietAo::where('id_chi_tiet_ao',$id_chi_tiet_ao)->first();
        ChiTietAo::where('id_chi_tiet_ao',$id_chi_tiet_ao)->update($data);
        Session::put('message','Cập nhật chi tiết ao nuôi thành công.');
        return redirect('bao-cao-ao/'.$id_back->ma_ao.'/'.$id_back->ma_khu.'/'.$id_back->ma_vu.'');
    }
    public function delete_chi_tiet_ao($id_chi_tiet_ao){
        $user = Auth::user();
        //dd($ma_ao);
        ChiTietAo::where('id_chi_tiet_ao',$id_chi_tiet_ao)->delete();
        Session::put('message','Xóa chi tiết ao nuôi thành công.');
        return redirect()->back();
    }
    public function bao_cao_ao(Request $request, $ma_ao, $ma_khu, $ma_vu){
        $user = Auth::user();
        //bao cao cua ao
        $lay_ten_khu = KhuNuoi::where('ma_khu',$ma_khu)->first();
        $lay_ten_vu = VuNuoi::where('ma_vu',$ma_vu)->first();
        if($lay_ten_khu && $lay_ten_vu){
            $ten_khu = $lay_ten_khu->ten_khu;
            $ten_vu = $lay_ten_vu->ten_vu;
        }
        $save_nk = AoNuoi::where('ma_ao',$ma_ao)->get();
        //lay ao hoat dong cung vu de sang/chiet
        $lay_ao_nuoi = AoNuoi::orderBy('ma_ao','ASC') // Orders the results by the 'ma_ao' column in ascending order.
        ->where('ao.ma_ao', '!=', $ma_ao) // Filters out rows where 'ma_ao' is not equal to a given value ($ma_ao).
        ->where('ao.trang_thai','Hoạt động') // Filters rows where the column 'trang_thai' in the 'ao' table is 'Hoạt động'.
        ->where('ao.ma_vu', $ma_vu) // Filters rows where 'ma_vu' column is equal to a given value ($ma_vu).
        ->join('khu_nuoi', 'khu_nuoi.ma_khu','=','ao.ma_khu') // Joins the 'khu_nuoi' table with the 'ao' table on 'ma_khu' and 'ma_khu' respectively.
        ->join('vu_nuoi', 'vu_nuoi.ma_vu','=','ao.ma_vu') // Joins the 'vu_nuoi' table with the 'ao' table on 'ma_vu' and 'ma_vu' respectively.
        ->get(); // Executes the query and returns the result as a collection.

        //dd($lay_ao_nuoi);
        $check_trang_thai_ao = AoNuoi::where('ma_ao', $ma_ao)->get();
        foreach($check_trang_thai_ao as $check_ao){
            $lay_trang_thai = $check_ao->trang_thai;
        }
        //dd($lay_trang_thai);
        $ma_ao_end = trim($ma_ao, '.');
        $ma_khu_end = trim($ma_khu, '.');
        $ma_vu_end = trim($ma_vu, '.');
        $lay_chi_tiet = ChiTietAo::query()
        ->where('ma_ao',$ma_ao_end)
        ->where('ma_khu',$ma_khu_end)
        ->where('ma_vu',$ma_vu_end);
        // ->orderBy('ngay','DESC');
        //dd($lay_chi_tiet->get());
        //Chart
        $ngayData = [];
        $luongTomGiongData = [];
        $luongThucAnData = [];
        $soTienChiData = [];
        $tong_tien_chi_ao = 0;
        $lay_ct = ChiTietAo::
        where('ma_ao',$ma_ao_end)
        ->where('ma_khu',$ma_khu_end)
        ->where('ma_vu',$ma_vu_end)
        ->orderBy('ngay','ASC')->get();
        foreach($lay_ct as $key => $val){
            $date = Carbon::parse($val->ngay)->format('d-m-Y');
            $ngayData[] = $date;
            $luongTomGiongData[] = $val->luong_tom_giong;
            $luongThucAnData[] = $val->luong_thuc_an;
            $soTienChiData[] = $val->tong_tien;
            $tong_tien_chi_ao += $val->tong_tien;
        }
        $bar_ngay = json_encode($ngayData);
        $bar_tom_giong = json_encode($luongTomGiongData);
        $bar_thuc_an = json_encode($luongThucAnData);
        $bar_tien_chi = json_encode($soTienChiData);
        //lay so  tom cua ngay lon nhat (ngay cuoi cung)
        $lay_sl_tom_end = ChiTietAo::where('ma_ao', $ma_ao_end)
        ->where('ma_khu', $ma_khu_end)
        ->where('ma_vu', $ma_vu_end)
        ->whereNotNull('luong_tom_giong')
        ->latest('ngay')
        ->first();
        // dd($lay_sl_tom_end->max('ngay'));
        if($lay_sl_tom_end == NULL){
            $sl_tom_end = 0;
        }else{
            foreach($lay_sl_tom_end as $value){
                $sl_tom_end = $lay_sl_tom_end->luong_tom_giong;
            }
        }
        //dd($lay_sl_tom_end);
        $lay_khach_hang = KhachHang::get();
        // tu dong tang ngay nuoi va tuoi
        $input_ngay_tuoi = ChiTietAo::where('ma_ao',$ma_ao_end)->where('ma_khu',$ma_khu_end)->where('ma_vu',$ma_vu_end)->latest('ngay')->first();
        if( $input_ngay_tuoi){
            $input_ngay = Carbon::parse($input_ngay_tuoi->ngay)->addDay();
            $input_ngay_format =  $input_ngay->format('Y-m-d');
            $input_tuoi = $input_ngay_tuoi->tuoi_tom + 1;
        }else{
            // $input_ngay = '';
            $input_ngay_format = '';
            $input_tuoi = '';
        }
        //dd($input_ngay, $input_tuoi);
        if($request->ajax()){
            return DataTables::of($lay_chi_tiet)
            ->editColumn('ngay', function($row) {
                $date = Carbon::parse($row->ngay)->format('d/m/Y');
                return '
                <a href="/all-chi-tiet-mot-ngay/'.$row->ma_ao.'/'.$row->ma_khu.'/'.$row->ma_vu.'/'.$row->ngay.'">
                    '.$date.'
                </a>
                ';
            })
            ->editColumn('luong_tom_giong',function($row) {
                if($row->luong_tom_giong ==''){
                    return '';
                }
                return number_format($row->luong_tom_giong).' con';
            })
            ->editColumn('sl_nhan_chiet',function($row) {
                if($row->sl_nhan_chiet ==''){
                    return '';
                }
                return number_format($row->sl_nhan_chiet).' con';
            })
            ->editColumn('tong_tien',function($row) {
                if($row->tong_tien ==''){
                    return '';
                }
                return '<span class="label label-danger" style="font-size: 11px;">'.number_format($row->tong_tien).' VND'.'</span>';
            })
            ->editColumn('luong_tom_sp', function($row) {
                if($row->luong_tom_sp ==''){
                    return '';
                }
                return number_format($row->luong_tom_sp).' gram';
            })
            ->editColumn('luong_thuc_an', function($row) {
                if($row->luong_thuc_an ==''){
                    return '';
                }
                return number_format($row->luong_thuc_an).' kg';
            })
            ->editColumn('ADG', function($row) {
                return $row->ADG;
            })
            ->editColumn('FCR', function($row) {
                return $row->FCR;
            })
            ->editColumn('size', function($row) {
                if($row->size ==''){
                    return '';
                }
                return number_format($row->size);
            })
            ->editColumn('hao_hut', function($row) {
                if($row->hao_hut ==''){
                    return '';
                }
                return number_format($row->hao_hut).' con';
            })
            ->editColumn('tinh_trang', function($row) {
                return '<span class="label label-warning">'.$row->tinh_trang.'</span>';
            })
            ->addColumn('xem', function($row){
                return'
                    <a href="/all-chi-tiet-mot-ngay/'.$row->ma_ao.'/'.$row->ma_khu.'/'.$row->ma_vu.'/'.$row->ngay.'">
                        Xem
                    </a>
               ';
            } )
            ->addColumn('Action', function($row){
                $max_ngay = ChiTietAo::where('ma_ao', $row->ma_ao)
                ->where('ma_khu', $row->ma_khu)
                ->where('ma_vu', $row->ma_vu)
                ->max('ngay');
                $action ='';
                if($row->ngay == $max_ngay){
                    $action .='
                    <div style="display:flex; border:none;">
                        <a href="/edit-chi-tiet-ao/'.$row->id_chi_tiet_ao.'">
                            <i class="fa fa-edit" style="font-size: 20px;margin-top: 3px;"></i>
                        </a>
                        <button type="button" class="" data-toggle="modal" data-target="#exampleModal'.$row->id_chi_tiet_ao.'" style="border: none;color:red;background-color: transparent;">
                        <span class="glyphicon glyphicon-trash"></span>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal'.$row->id_chi_tiet_ao.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
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
                                    Bạn có chắc chắn muốn xóa ngày nuôi không?
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a href="/delete-chi-tiet-ao/'.$row->id_chi_tiet_ao.'">
                                    <button type="button" class="btn btn-danger">Xóa</button>
                                </a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    ';
                }
                return $action;
            } )->rawColumns(['nhiet_do_khi','nhiet_do_nuoc','TT','ngay','ADG','FCR','size','hao_hut', 'tinh_trang','xem', 'Action','sl_nhan_chiet','tong_tien'])
            ->make(true);
        }
        return view('admin.bao_cao_ao',[
            'lay_ao_nuoi' => $lay_ao_nuoi,
            'user' => $user,
            'ma_ao' => $ma_ao,
            'ten_khu' => $ten_khu,
            'ten_vu' => $ten_vu,
            'ma_khu' => $ma_khu,
            'ma_vu' => $ma_vu,
            'bar_ngay' => $bar_ngay,
            'bar_thuc_an' => $bar_thuc_an,
            'bar_tom_giong' => $bar_tom_giong,
            'bar_tien_chi' => $bar_tien_chi,
            'sl_tom_end' => $sl_tom_end,
            'lay_trang_thai' => $lay_trang_thai,
            'tong_tien_chi_ao' => $tong_tien_chi_ao,
            'save_nk' => $save_nk,
            'lay_khach_hang' => $lay_khach_hang,
            'input_tuoi' => $input_tuoi,
            'input_ngay' => $input_ngay_format,
        ]);
    }
    public function all_chi_tiet_mot_ngay(Request $request, $ma_ao, $ma_khu, $ma_vu, $ngay){
        $user = Auth::user();
        $lay_ten_khu = KhuNuoi::where('ma_khu',$ma_khu)->first();
        $lay_ten_vu = VuNuoi::where('ma_vu',$ma_vu)->first();
        if($lay_ten_khu && $lay_ten_vu){
            $ten_khu = $lay_ten_khu->ten_khu;
            $ten_vu = $lay_ten_vu->ten_vu;
        }
        // $lay_nhat_ky = NhatKy::orderBy('id_nhat_ky','ASC')->get();
        $lay_ten_ao = AoNuoi::where('ma_ao', $ma_ao)->first();
        if($lay_ten_ao){
            $ten_ao = $lay_ten_ao->ten_ao;
        }
        $check_trang_thai_ao = AoNuoi::where('ma_ao', $ma_ao)->get();
        foreach($check_trang_thai_ao as $check_ao){
            $lay_trang_thai = $check_ao->trang_thai;
        }
        $ma_ao_end = trim($ma_ao, '.');
        $ma_khu_end = trim($ma_khu, '.');
        $ma_vu_end = trim($ma_vu, '.');
        $ngay_end = trim($ngay, '.');
        // $id_chi_tiet = ChiTietAo::where('ma_ao',$ma_ao_end)->where('ma_khu',$ma_khu_end)->where('ma_vu',$ma_vu_end)->where('ngay',$ngay_end)->get();
        // if($id_chi_tiet){
        //     $id_ct = $id_chi_tiet->id_chi_tiet_ao;
        // }
        //dd($id_chi_tiet);
        $lay_chi_tiet = ChiTietAo::
        leftjoin('moi_truong','moi_truong.id_chi_tiet_ao','=','chi_tiet_ao.id_chi_tiet_ao')
        // ->leftjoin('nhat_ky','nhat_ky.id_chi_tiet_ao','=','chi_tiet_ao.id_chi_tiet_ao')
        ->where('ma_ao',$ma_ao_end)
        ->where('ma_khu',$ma_khu_end)
        ->where('ma_vu',$ma_vu_end)
        ->where('ngay',$ngay_end)
        ->get();
        //dd($lay_chi_tiet);
        $lay_nhat_ky = ChiTietAo::
        leftjoin('nhat_ky','nhat_ky.id_chi_tiet_ao','=','chi_tiet_ao.id_chi_tiet_ao')
        ->leftjoin('vat_tu','vat_tu.ma_vat_tu','=','nhat_ky.ma_vat_tu')
        ->where('ma_ao',$ma_ao_end)
        ->where('ma_khu',$ma_khu_end)
        ->where('ma_vu',$ma_vu_end)
        ->where('ngay',$ngay_end)->get();

        //dd($lay_nhat_ky);
        $lay_id_chi_tiet = ChiTietAo::
        where('ma_ao',$ma_ao_end)
        ->where('ma_khu',$ma_khu_end)
        ->where('ma_vu',$ma_vu_end)
        ->where('ngay',$ngay_end)->select('id_chi_tiet_ao')->get();
        foreach($lay_id_chi_tiet as $value){
            $id_ct = $value->id_chi_tiet_ao;
        }
        $check_moi_truong = MoiTruong::where('id_chi_tiet_ao', $id_ct)->first();
        //dd($check_moi_truong);
        $all_vat_tu = VatTu::all();
        //dd($lay_id_chi_tiet);
        $max_ngay = ChiTietAo::where('ma_ao', $ma_ao_end)
        ->where('ma_khu', $ma_khu_end)
        ->where('ma_vu', $ma_vu_end)
        ->max('ngay');
        $lay_vat_tu = VatTu::orderBy('ma_vat_tu','DESC')->get();
        return view('admin.all_chi_tiet_mot_ngay',[
            'check_moi_truong' => $check_moi_truong,
            'lay_chi_tiet' => $lay_chi_tiet,
            'lay_nhat_ky' =>$lay_nhat_ky,
            'id_ct' =>$id_ct,
            'vat_tu' => $lay_vat_tu,
            'user' => $user,
            'ngay' => $ngay_end,
            'ma_ao' => $ma_ao,
            'ma_khu' => $ma_khu,
            'ma_vu' => $ma_vu,
            'ten_ao' => $ten_ao,
            'ten_khu' => $ten_khu,
            'ten_vu' => $ten_vu,
            'max_ngay' => $max_ngay,
            'lay_trang_thai' => $lay_trang_thai,
        ]);
    }
    public function save_ban_tom(Request $request, $ma_ao, $ma_khu, $ma_vu){
        if($request->id_khach_hang == null){
            Session::put('error','Vui lòng chọn khách hàng!!!.');
            return redirect()->back();
        }elseif($request->lay_thanh_tien == null){
            Session::put('error','Vui lòng nhập số kg tôm bán và giá tiền 1kg tôm!!!.');
            return redirect()->back();
        }
        $check_ngay_nuoi = ChiTietAo::where('ma_ao',$ma_ao)->where('ma_khu',$ma_khu)->where('ma_vu',$ma_vu)->latest('ngay')->get();
        //dd(count($check_ngay_nuoi));
        $count_co_tom = 0;
            if(count($check_ngay_nuoi) == 0){
                Session::put('error','Ao rỗng, không thể bán !!!.');
                return redirect()->back();
            }else{
                foreach( $check_ngay_nuoi as $check){
                    if( $check->luong_tom_giong != null){
                        $count_co_tom += 1;
                    }
                }
            }
            // dd($count_co_tom);
            if($count_co_tom == 0){
                Session::put('error','Lượng tôm giống rỗng, không thể bán !!!.');
                return redirect()->back();
            }
        $check_ban_tom = AoNuoi::where('ma_ao',$ma_ao)->where('ma_khu',$ma_khu)->where('ma_vu',$ma_vu)->get();
        foreach($check_ban_tom as $value){
            if($value->ao_cha == null){
                $value->update([
                    'ao_cha' => $ma_ao,
                ]);
            }
            $lay_ao_cha = AoNuoi::where('ma_ao',$ma_ao)->where('ma_khu',$ma_khu)->where('ma_vu',$ma_vu)->select('ao_cha')->get();
            //dd($lay_ao_cha);
            foreach($lay_ao_cha as $lay_value){
                $lay_ma = AoNuoi::query()
                ->where('ma_ao', $lay_value->ao_cha)
                ->orWhere('ao_cha', $lay_value->ao_cha)
                ->get();
            }
        //dd($lay_ma->doanh_thu);
            $ds_ma_ao = $lay_ma->pluck('ma_ao')->toArray();
        // dd($lay_ma_ao);
            $lay_tong_chi = ChiTietAo::whereIn('ma_ao', $ds_ma_ao)->get();
            //dd($lay_tong_chi);
            $tong_tien_chi_cac_ao = 0;
            foreach($lay_tong_chi as $val){
                $tong_tien_chi_cac_ao += $val->tong_tien;
            }
            //dd($tong_tien_chi_cac_ao);
            $doanh_thu = $request->lay_thanh_tien;
            $loi_nhuan = $doanh_thu - $tong_tien_chi_cac_ao;
            $value->update([
                'id_khach_hang' => $request->id_khach_hang,
                'doanh_thu' => $doanh_thu,
                'tong_chi' => $tong_tien_chi_cac_ao,
                'loi_nhuan' => $loi_nhuan,
                'trang_thai' => 'Đã bán',
            ]);
            // Session::put('message','Bán tôm thành công ('.$ma_ao.'-'.$ten_khu.'-'.$ten_vu.')');
            Session::put('message','Bán tôm thành công.');
            return Redirect::to('all-ao-nuoi');
        }
    }
    public function tinh_adg($ma_ao, $ma_khu, $ma_vu){
        $check_adg_dau = ChiTietAo::where('ma_ao',$ma_ao)->where('ma_khu',$ma_khu)->where('ma_vu',$ma_vu)
        ->whereNotNull('adg')->get();
        if(!$check_adg_dau->isEmpty()){
            $ngay_lon = ChiTietAo::where('ma_ao',$ma_ao)->where('ma_khu',$ma_khu)->where('ma_vu',$ma_vu)->latest('ngay')->first();
            $ngay_nho = ChiTietAo::where('ma_ao',$ma_ao)->where('ma_khu',$ma_khu)->where('ma_vu',$ma_vu)
            ->where('ngay','<',$ngay_lon->ngay)->whereNotNull('ADG')->latest('ngay')->first();
        }else{
            $ngay_nho = ChiTietAo::where('ma_ao',$ma_ao)->where('ma_khu',$ma_khu)->where('ma_vu',$ma_vu)->oldest('ngay')->first();
            $ngay_lon = ChiTietAo::where('ma_ao',$ma_ao)->where('ma_khu',$ma_khu)->where('ma_vu',$ma_vu)->latest('ngay')->first();
        }
        //dd($ngay_nho->ngay,$ngay_lon->ngay);
        if($ngay_lon){
            if($ngay_lon->ADG){
                $ngay_tinh = Carbon::parse($ngay_lon->ngay)->format('d/m/Y');
                Session::put('error','Ngày '.$ngay_tinh.' đã tính ADG/ FCR/ Hao hụt trước đó.');
                return redirect()->back();
            }
        }
        if($ngay_nho && $ngay_lon){
            $tu_ngay = Carbon::parse($ngay_nho->ngay);
            $den_ngay = Carbon::parse($ngay_lon->ngay);
            $thoi_gian_khoang_cach = $tu_ngay->diffInDays($den_ngay);
            // dd($tu_ngay, $den_ngay, $thoi_gian_khoang_cach);
            if($thoi_gian_khoang_cach < 5){
                Session::put('error','Khoảng cách tối thiểu 5 ngày.');
                return redirect()->back();
            }
            if($ngay_nho->size && $ngay_nho->luong_tom_giong && $ngay_lon->size && $ngay_lon->luong_tom_giong){
                //Tinh hao hut
                if(!$check_adg_dau->isEmpty()){
                    $lay_tong_sp = ChiTietAo::where('ngay','<=',$den_ngay)->where('ngay','>',$tu_ngay)
                    ->where('ma_ao',$ma_ao)->where('ma_khu',$ma_khu)->where('ma_vu',$ma_vu)->orderBy('ngay','ASC')->get();
                }else{
                    $lay_tong_sp = ChiTietAo::where('ngay','<=',$den_ngay)->where('ngay','>=',$tu_ngay)
                    ->where('ma_ao',$ma_ao)->where('ma_khu',$ma_khu)->where('ma_vu',$ma_vu)->orderBy('ngay','ASC')->get();
                }
                //dd($lay_tong_sp);
                $sum_sp = 0;
                foreach($lay_tong_sp as $value){
                    $sum_sp += $value->luong_tom_sp;
                }
                //dd($sum_sp);
                $hao_hut = ($sum_sp/1000)*(($ngay_lon->size + $ngay_nho->size)/2);
                $luong_tom_giong_moi = $ngay_lon->luong_tom_giong - $hao_hut;
                //dd($hao_hut, $luong_tom_giong_moi);
                ChiTietAo::where('ngay',$den_ngay)->where('ma_ao',$ma_ao)->where('ma_khu',$ma_khu)
                ->where('ma_vu',$ma_vu)->update([
                    'hao_hut' => $hao_hut,
                    'luong_tom_giong' => $luong_tom_giong_moi,
                ]);
                // Tinh FCR
                $lay_tong_thuc_an = ChiTietAo::where('ngay','<',$den_ngay)->where('ngay','>=',$tu_ngay)
                ->where('ma_ao',$ma_ao)->where('ma_khu',$ma_khu)->where('ma_vu',$ma_vu)->get();
                //dd($lay_tong_thuc_an);
                $sum_thuc_an = 0;
                foreach($lay_tong_thuc_an as $value){
                    $sum_thuc_an += $value->luong_thuc_an;
                }
                $fcr = $sum_thuc_an/(( $luong_tom_giong_moi/$ngay_lon->size)-($ngay_nho->luong_tom_giong/$ngay_nho->size));
                $fcr_rut_gon = round($fcr, 2);
                //dd($fcr_rut_gon);
                //dd($sum_thuc_an_fcr, $luong_tom_giong_moi,$ngay_lon->size,$ngay_nho->luong_tom_giong,$ngay_nho->size);
                ChiTietAo::where('ngay',$den_ngay)->where('ma_ao',$ma_ao)->where('ma_khu',$ma_khu)
                ->where('ma_vu',$ma_vu)->update([
                    'FCR' => $fcr_rut_gon
                ]);
                // Tinh ADG
                $adg = ((1000/$ngay_lon->size) - (1000/$ngay_nho->size))/$thoi_gian_khoang_cach;
                $adg_rut_gon = round($adg, 2);
                //dd($so_rut_gon);
                ChiTietAo::where('ngay',$den_ngay)->where('ma_ao',$ma_ao)->where('ma_khu',$ma_khu)
                ->where('ma_vu',$ma_vu)->update([
                    'ADG' => $adg_rut_gon
                ]);
                //dd( $fcr_rut_gon, $adg_rut_gon);
                Session::put('message','Tính ADG/ FCR/ hao hụt thành công.');
                return redirect()->back();
            }else{
                Session::put('error','Size tôm và lượng tôm giống không tồn tại.');
                return redirect()->back();
            }
        }else{
            Session::put('error','Ngày nuôi này không tồn tại.');
            return redirect()->back();
        }
    }
    public function chiet_tom(Request $request, $ma_ao){
        $ma_ao_nhan = $request->ma_ao_nhan;
        $sl_tom_sc = $request->so_luong_tom;
        if($ma_ao_nhan == null || $sl_tom_sc == null){
            Session::put('error','Hãy nhập số lượng chiết và chọn ao nhận.');
            return redirect()->back();
        }
        $ao_chiet = ChiTietAo::where('ma_ao', $ma_ao)->latest('ngay')->first();
        //dd($ao_chiet);
        $ao_nhan = ChiTietAo::where('ma_ao', $ma_ao_nhan)->latest('ngay')->first();
        //dd($ao_nhan);
        $mess_lay_ten_ao_nhan = AoNuoi::where('ma_ao',$ma_ao_nhan)->first();
        $mess_ten_ao_nhan = $mess_lay_ten_ao_nhan->ten_ao;
        if($ao_chiet->luong_tom_giong == null || $ao_chiet->size == null){
            Session::put('error','Số lượng tôm, size rỗng. Không thể chiết.');
            return redirect()->back();
        }
        if($sl_tom_sc <= 0){
            Session::put('error','Số lượng chiết phải lớn hơn 0.');
            return redirect()->back();
        }elseif($sl_tom_sc > $ao_chiet->luong_tom_giong){
            Session::put('error','Số lượng chiết vượt quá số tôm có trong ao.');
            return redirect()->back();
        }
        if($ao_nhan == null){
            //ao chiet
            if($ao_chiet){
                $lay_ten_ao_nhan = AoNuoi::where('ma_ao', $ma_ao_nhan)->first();
                $sl_moi_ao_chiet = $ao_chiet->luong_tom_giong - $sl_tom_sc;
                $ao_chiet->update([
                    'luong_tom_giong' => $sl_moi_ao_chiet,
                    'tinh_trang' => 'Chiết sang '.$lay_ten_ao_nhan->ten_ao.'',
                    'sl_nhan_chiet' => $sl_tom_sc
                ]);
            }
            //ao nhan
            $ao_nuoi = AoNuoi::where('ma_ao',$ma_ao_nhan)->first();
            $chiet = new ChiTietAo();
            $chiet->ma_ao = $ma_ao_nhan;
            if($ao_nuoi){
                $lay_ten_ao_nhan = $ao_nuoi->ten_ao;
                $chiet->ma_khu = $ao_nuoi->ma_khu;
                $chiet->ma_vu = $ao_nuoi->ma_vu;
            }
            $chiet->ngay = $ao_chiet->ngay;
            $chiet->size = $ao_chiet->size;
            $lay_ten_ao_chiet = AoNuoi::where('ma_ao',$ma_ao)->first();
            if($lay_ten_ao_chiet){
                $chiet->tinh_trang = 'Nhận từ '.$lay_ten_ao_chiet->ten_ao;
            }
            $chiet->sl_nhan_chiet = $sl_tom_sc;
            $chiet->tuoi_tom = $ao_chiet->tuoi_tom;
            $chiet->luong_thuc_an = 0;
            $chiet->luong_tom_giong = $sl_tom_sc;
            $chiet->luong_tom_sp = 0;
            $chiet->ADG = null;
            $chiet->FCR = null;
            $chiet->hao_hut = null;
            $chiet->save();
        }elseif($ao_nhan != null){
            if($ao_chiet->ngay != $ao_nhan->ngay){
                Session::put('error','Ngày chiết và ngày nhận không trùng khớp!!!.');
                return redirect()->back();
            }
            if($ao_nhan->luong_tom_giong == null || $ao_nhan->size == null){
                Session::put('error','Size và số lượng tôm giống ao nhận rỗng, không thể chiết!!!.');
                return redirect()->back();
            }
            if($ao_chiet){
                //dd($ao_chiet);
                $lay_ten_ao_nhan = AoNuoi::where('ma_ao', $ma_ao_nhan)->first();
                $sl_moi_ao_chiet = $ao_chiet->luong_tom_giong - $sl_tom_sc;
                $ao_chiet->update([
                    'luong_tom_giong' => $sl_moi_ao_chiet,
                    'tinh_trang' => 'Chiết sang '.$lay_ten_ao_nhan->ten_ao.'',
                    'sl_nhan_chiet' => $sl_tom_sc
                ]);
            }
            if($ao_nhan){
                $lay_ten_ao_chiet = AoNuoi::where('ma_ao', $ma_ao)->first();
                $sl_moi_ao_nhan = $ao_nhan->luong_tom_giong + $sl_tom_sc;
                $ao_nhan->update([
                    // 'tuoi_tom' => $ao_chiet->tuoi_tom,
                    // 'size' => $ao_chiet->size,
                    'luong_tom_giong' => $sl_moi_ao_nhan,
                    'tinh_trang' => 'Nhận từ '.$lay_ten_ao_chiet->ten_ao.'',
                    'sl_nhan_chiet' => $sl_tom_sc,
                ]);
            }
        }
        Session::put('message','Chiết '.number_format($sl_tom_sc).' con sang '.$mess_ten_ao_nhan.' thành công.');
        return redirect()->back();
    }
    public function sang_tom(Request $request, $ma_ao){
        $ma_ao_nhan = $request->ma_ao_nhan_sang;
        if($ma_ao_nhan == null){
            Session::put('error','Hãy chọn ao nhận lượng tôm sang.');
            return redirect()->back();
        }
        //lay ten ao sang tom
        $lay_ao_sang = AoNuoi::where('ma_ao', $ma_ao)->first();
        //lay ngay lon nhat cua ao sang
        $ao_sang = ChiTietAo::where('ma_ao', $ma_ao)->latest('ngay')->first();
        if($ao_sang->size == null || $ao_sang->luong_tom_giong == null){
            Session::put('error','Ao sang phải có size, lượng tôm giống.');
            return redirect()->back();
        }
        $ao_nuoi = AoNuoi::where('ma_ao',$ma_ao_nhan)->first();
        if($ao_sang){
            $lay_ten_ao_sang = $lay_ao_sang->ten_ao;
            $lay_ma_khu = $ao_nuoi->ma_khu;
            $lay_ma_vu = $ao_nuoi->ma_vu;
            $lay_ngay = Carbon::parse($ao_sang->ngay)->addDay();
            $lay_tuoi_tom = $ao_sang->tuoi_tom;
            $lay_luong_tom_giong = $ao_sang->luong_tom_giong;
            $lay_size = $ao_sang->size;
            $lay_sl_nhan_chiet = $ao_sang->luong_tom_giong;
        }
        if($ao_nuoi){
            $lay_ten_ao_nhan = $ao_nuoi->ten_ao;
            $check_ao_nhan = ChiTietAo::where('ma_ao',$ma_ao_nhan)->get();
            // dd($check_ao_nhan);
            foreach($check_ao_nhan as $check){
                if($check){
                    Session::put('error','Ao nhận phải trống lịch sử nuôi.');
                    return redirect()->back();
                }
            }
            $check_ao_sang = AoNuoi::where('ma_ao',$ma_ao)->get();
            foreach( $check_ao_sang as $check){
                //dd($check->ao_cha);
                if($check->ao_cha == null){
                    $ao_nuoi->update([
                        'ao_cha' => $ma_ao,
                    ]);
                }else{
                    $ao_nuoi->update([
                        'ao_cha' => $check->ao_cha,
                    ]);
                }
            }
        }
        $nhat_ky = new ChiTietAo();
        $nhat_ky->ma_ao = $ma_ao_nhan;
        $nhat_ky->ma_khu = $lay_ma_khu;
        $nhat_ky->ma_vu = $lay_ma_vu;
        $nhat_ky->ngay = $lay_ngay;
        $nhat_ky->tuoi_tom = $lay_tuoi_tom + 1;
        $nhat_ky->luong_thuc_an = 0;
        $nhat_ky->luong_tom_giong = $lay_luong_tom_giong;
        $nhat_ky->luong_tom_sp = 0;
        $nhat_ky->ADG = null;
        $nhat_ky->FCR = null;
        $nhat_ky->size = $lay_size;
        $nhat_ky->hao_hut = null;
        $nhat_ky->tinh_trang = 'Nhận từ '.$lay_ten_ao_sang;
        $nhat_ky->sl_nhan_chiet = $lay_sl_nhan_chiet;
        //dd($nhat_ky);
        $nhat_ky->save();
        AoNuoi::where('ma_ao',$ma_ao)->update([
            'trang_thai' => 'Ngừng hoạt động'
        ]);
        $ao_sang->update([
            'tinh_trang' => 'Sang qua '.$lay_ten_ao_nhan.'',
            'sl_nhan_chiet' => $lay_sl_nhan_chiet,
        ]);
        Session::put('message','Sang tất cả tôm qua '.$lay_ten_ao_nhan.' thành công.');
        return redirect()->back();
    }
    public function save_gia_tom(Request $request){
        $data = $request->all();
        //dd($data);
        $gia_tom = new GiaTom();
        $gia_tom->ngay_ban = $data['ngay_ban'];
        $gia_tom->gia_ban = $data['gia_ban'];
        if(($data['ngay_ban'] == '') || ($data['gia_ban'] == '')){
            Session::put('error','Vui lòng nhập đầy đủ thông tin!!!.');
            return redirect()->back();
        }
        $check_gia = GiaTom::get();
        foreach($check_gia as $check){
            if($check->ngay_ban == $data['ngay_ban']){
                $date = Carbon::parse($check->ngay_ban)->format('d/m/Y');
                Session::put('error','Ngày '.$date.' đã tồn tại!!!.');
                return redirect()->back();
            }
        }
        $gia_tom->save();
        Session::put('message','Thêm giá tôm thành công.');
        return redirect()->back();
    }
    public function lich_su_nuoi(Request $request, $ao_cha){
        $user = Auth::user();
        $ma_ao_cha_end = trim($ao_cha, '.');
        $lay_ma = AoNuoi::query()
        ->where('ma_ao', $ma_ao_cha_end)
        ->orWhere('ao_cha', $ma_ao_cha_end)
        ->get();
        //dd($lay_ma->doanh_thu);
        foreach($lay_ma as $value){
            $doanh_thu = $value->doanh_thu;
            $tong_chi = $value->tong_chi;
            $loi_nhuan = $value->loi_nhuan;
        }
        $lay_ma_ao = $lay_ma->pluck('ma_ao')->toArray();
        // dd($lay_ma_ao);
        $lay_lich_su = ChiTietAo::query()->whereIn('ma_ao', $lay_ma_ao)->get();
        // dd($lay_lich_su);
        $khach_hang = AoNuoi::query()->whereIn('ma_ao', $lay_ma_ao)->get();
        $lay_thong_tin_ao = AoNuoi::whereIn('ma_ao', $lay_ma_ao)
        ->leftJoin('khu_nuoi', 'ao.ma_khu', '=', 'khu_nuoi.ma_khu')
        ->leftJoin('vu_nuoi', 'ao.ma_vu', '=', 'vu_nuoi.ma_vu')
        ->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
        foreach($khach_hang as $kh){
            $id_khach_hang = $kh->id_khach_hang;
        }
        $lay_khach_hang = KhachHang::where('id_khach_hang',$id_khach_hang)->get();
        //dd($lay_khach_hang);
        //Chart
        $ngayData = [];
        $luongTomGiongData = [];
        $luongThucAnData = [];
        $soTienChiData = [];
        $tong_tien_chi = 0;
        foreach($lay_lich_su as $key => $val){
            $date = Carbon::parse($val->ngay)->format('d-m-Y');
            $ngayData[] = $date;
            $luongTomGiongData[] =  $val->luong_tom_giong;
            $luongThucAnData[] = $val->luong_thuc_an;
            $soTienChiData[] = $val->tong_tien;
            $tong_tien_chi += $val->tong_tien;
        }
        $bar_ngay = json_encode($ngayData);
        $bar_tom_giong = json_encode($luongTomGiongData);
        $bar_thuc_an = json_encode($luongThucAnData);
        $bar_tien_chi = json_encode($soTienChiData);
        //dd($lay_sl_tom_end);
        if($request->ajax()){
            return DataTables::of($lay_lich_su)
            ->editColumn('ngay', function($row) {
                $date = Carbon::parse($row->ngay)->format('d/m/Y');
                return '
                <a href="/all-chi-tiet-mot-ngay/'.$row->ma_ao.'/'.$row->ma_khu.'/'.$row->ma_vu.'/'.$row->ngay.'">
                    '.$date.'
                </a>
                ';
            })
            ->editColumn('luong_tom_giong',function($row) {
                if($row->luong_tom_giong ==''){
                    return '';
                }
                return number_format($row->luong_tom_giong).' con';
            })
            ->editColumn('luong_tom_sp', function($row) {
                if($row->luong_tom_sp ==''){
                    return '';
                }
                return number_format($row->luong_tom_sp).' gram';
            })
            ->editColumn('sl_nhan_chiet',function($row) {
                if($row->sl_nhan_chiet ==''){
                    return '';
                }
                return number_format($row->sl_nhan_chiet).' con';
            })
            ->editColumn('luong_thuc_an', '{{$luong_thuc_an}} kg')
            ->editColumn('ADG', function($row) {
                return $row->ADG;
            })
            ->editColumn('FCR', function($row) {
                return $row->FCR;
            })
            ->editColumn('size', function($row) {
                if($row->size ==''){
                    return '';
                }
                return number_format($row->size);
            })
            ->editColumn('hao_hut', function($row) {
                if($row->hao_hut ==''){
                    return '';
                }
                return number_format($row->hao_hut).' con';
            })
            ->editColumn('tong_tien', function($row) {
                if($row->tong_tien ==''){
                    return '';
                }
                return '<span class="label label-danger" style="font-size: 11px;">'.number_format($row->tong_tien).' VND'.'</span>';
            })
            ->editColumn('tinh_trang', function($row) {
                return '<span class="label label-warning">'.$row->tinh_trang.'</span>';
            })
            ->addColumn('xem', function($row){
                return'
                    <a href="/all-chi-tiet-mot-ngay/'.$row->ma_ao.'/'.$row->ma_khu.'/'.$row->ma_vu.'/'.$row->ngay.'">
                        Xem
                    </a>
               ';
            })
            ->rawColumns(['nhiet_do_khi','nhiet_do_nuoc','TT','ngay','ADG','FCR','size','hao_hut', 'tinh_trang','xem', 'Action','sl_nhan_chiet','tong_tien'])
            ->make(true);
        }
        return view('admin.lich_su_nuoi',[
            'doanh_thu' => $doanh_thu,
            'tong_chi' => $tong_chi,
            'loi_nhuan' => $loi_nhuan,
            'user' => $user,
            'ao_cha' => $ao_cha,
            'tong_tien_chi' => $tong_tien_chi,
            'lay_khach_hang' => $lay_khach_hang,
            'bar_ngay' => $bar_ngay,
            'bar_tom_giong' => $bar_tom_giong,
            'bar_thuc_an' => $bar_thuc_an,
            'bar_tien_chi' => $bar_tien_chi,
            'lay_thong_tin_ao' => $lay_thong_tin_ao,
            // 'sl_tom_end' => $sl_tom_end,
            // 'lay_trang_thai' => $lay_trang_thai
        ]);

    }
    public function xuat_lich_su_nuoi(Request $request, $ao_cha){
        $pdf = new Dompdf();
        $pdf->loadHtml($this->print_lich_su_nuoi($ao_cha));
        $pdf->render();
        // return $pdf->stream();
        // Thiết lập header của phản hồi để mở PDF trong tab mới
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="lich_su_nuoi.pdf"',
        ];
        // Trả về phản hồi với PDF
        return response($pdf->output(), 200, $headers);
    }
    public function print_lich_su_nuoi($ao_cha){
        $ma_ao_cha_end = trim($ao_cha, '.');
        $lay_ma = AoNuoi::where('ma_ao', $ma_ao_cha_end)
        ->orWhere('ao_cha', $ma_ao_cha_end)
        ->get();
        //dd($lay_ma->doanh_thu);
        foreach($lay_ma as $value){
            $doanh_thu = $value->doanh_thu;
            $tong_chi = $value->tong_chi;
            $loi_nhuan = $value->loi_nhuan;
        }
        $lay_ma_ao = $lay_ma->pluck('ma_ao')->toArray();
        //dd($lay_ma_ao);
        $lay_thong_tin_ao = AoNuoi::whereIn('ma_ao', $lay_ma_ao)
        ->join('khu_nuoi','khu_nuoi.ma_khu','=','ao.ma_khu')
        ->join('vu_nuoi','vu_nuoi.ma_vu','=','ao.ma_vu')
        ->select('ao.*', 'khu_nuoi.ten_khu', 'vu_nuoi.ten_vu')->get();
        $lay_lich_su = ChiTietAo::whereIn('ma_ao', $lay_ma_ao)->orderBy('tuoi_tom','ASC')->get();
        $khach_hang = AoNuoi::query()->whereIn('ma_ao', $lay_ma_ao)->get();
        foreach($khach_hang as $kh){
            $id_khach_hang = $kh->id_khach_hang;
        }
        $lay_khach_hang = KhachHang::where('id_khach_hang',$id_khach_hang)->get();
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->format('d-m-Y H:i:s');
        $in_lich_su = '';
        $in_lich_su .=
        '<style>
        body{
            font-family: DeJavu Sans
        }
        </style>
        <p style="font-size:20px; text-align:center;">XUẤT LỊCH SỬ NUÔI</p>
        <p style="font-size:12px; text-align:center;">(Thời gian xuất PDF: '.$formattedDateTime.')</p>
        <table class="table table-striped b-t b-light" style="border: 1px solid #000000;width: 100%; font-size:12px; margin-bottom:10px; padding:0px 20px 0px 20px;">
            <div style="">
            <p style="font-size:14px; text-align: center;">Thông tin nuôi qua các ao:</p>';
            foreach($lay_thong_tin_ao as $val){
                $in_lich_su .= '
                <p>Tên ao: '.$val->ten_ao.' - Tên khu: '.$val->ten_khu.' - Tên vụ: '.$val->ten_vu.'</p>
                ';
            }
            $in_lich_su .='
            </div>
        </table>
        <table class="table table-striped b-t b-light" style="border: 1px solid #000000;width: 100%; font-size:12px; margin-bottom:10px; padding:0px 20px 0px 20px;">
            <p style="font-size:14px; text-align: center;">Thông tin khách hàng - Doanh thu:</p>
            <div style="display:flex;">';
                foreach($lay_khach_hang as $value){
                    $in_lich_su .= '
                    <div>
                        <p>Tên khách hàng: '.$value->ten_khach_hang.' ('.$value->loai_khach_hang.')'.'</p>
                        <p>Số điện thoại: '.$value->so_dien_thoai.'</p>
                        <p>Địa chỉ: '.$value->dia_chi.'</p>
                    </div>
                    ';
                }
                $in_lich_su .='
                <div>
                    <p>Tổng tiền bán tôm: '.number_format($doanh_thu).' '.' VND'.'</p>
                    <p>Tổng tiền chi: '.number_format($tong_chi).' '.' VND'.'</p>
                    <p>Lợi nhuận: '.number_format($loi_nhuan).' '.' VND'.'</p>
                </div>
            </div>
        </table>
        <table class="table table-striped b-t b-light" style="border: 1px solid #000000; width: 100%;margin-bottom:10px;font-size:10px;padding: 5px;text-align: center;">
            <thead>
                <tr>
                    <th style="width: 85px;">Ngày</th>
                    <th>Tuổi</th>
                    <th>Lượng thức ăn</th>
                    <th>Lượng tôm giống (con)</th>
                    <th>Lượng tôm SP (gram)</th>
                    <th>Size</th>
                    <th>ADG</th>
                    <th>FCR</th>
                    <th style="width: 60px;">Hao hụt (con)</th>
                    <th style="width: 85px;">Sang/ Chiết</th>
                    <th>SL nhận/chiết (con)</th>
                    <th style="width: 85px;">Tiền chi</th>
                </tr>
            </thead>
            <tbody>';
                foreach($lay_lich_su as $value){
                    $in_lich_su .='
                <tr>
                    <td>'.Carbon::parse($value->ngay)->format('d/m/Y').'</td>
                    <td>'.$value->tuoi_tom.'</td>
                    <td>'.number_format($value->luong_thuc_an).' '.' kg'.'</td>';
                    if($value->luong_tom_giong == null){
                        $in_lich_su .='<td>-</td>';
                    }else{
                        $in_lich_su .='<td>'.number_format($value->luong_tom_giong).'</td>';
                    }
                    if($value->luong_tom_sp == null){
                        $in_lich_su .='<td>-</td>';
                    }else{
                        $in_lich_su .='<td>'.number_format($value->luong_tom_sp).'</td>';
                    }
                    if($value->size == null){
                        $in_lich_su .='<td>-</td>';
                    }else{
                        $in_lich_su .='<td>'.number_format($value->size).'</td>';
                    }
                    if($value->ADG == null){
                        $in_lich_su .='<td>-</td>';
                    }else{
                        $in_lich_su .='<td>'.$value->ADG.'</td>';
                    }
                    if($value->FCR == null){
                        $in_lich_su .='<td>-</td>';
                    }else{
                        $in_lich_su .='<td>'.$value->FCR.'</td>';
                    }
                    if($value->hao_hut == null){
                        $in_lich_su .='<td>-</td>';
                    }else{
                        $in_lich_su .='<td>'.number_format($value->hao_hut).'</td>';
                    }
                    if($value->tinh_trang == null){
                        $in_lich_su .='<td>-</td>';
                    }else{
                        $in_lich_su .='<td>'.$value->tinh_trang.'</td>';
                    }
                    if($value->sl_nhan_chiet == null){
                        $in_lich_su .='<td>-</td>';
                    }else{
                        $in_lich_su .='<td>'.number_format($value->sl_nhan_chiet).'</td>';
                    }
                    $in_lich_su .='
                    <td>'.number_format($value->tong_tien).' '.' VND'.'</td>
                </tr>';
                }
                $in_lich_su .='
            </tbody>
        </table>
        ';
    return $in_lich_su;
    }


    // public function index(Request $request)
    // {
    //     if (!Sentinel::hasAccess('contract')) {
    //         Flash::warning("Permission Denied");
    //         return redirect('/');
    //     }
    //     $hideStaffName = false;

    //     $query = Contract::query()->leftjoin('users', 'users.user_code', 'contracts.user_code')
    //         ->select('contracts.*', 'unit_code', 'leader');

    //     $user = Sentinel::getUser();
    //     $getRoles = $user->roles->pluck('slug');
    //     $isUser = false;
    //     if ($getRoles->contains('nhan_vien')) {
    //         $isUser = true;
    //     }
    //     if (!$getRoles->contains('admin')) {
    //         $query->where('unit_code', $user->unit_code);
    //         if (!$user->admin) {
    //             $query->where('contracts.user_code', $user->user_code);
    //             $hideStaffName = true;
    //         }
    //     }
    //     $clone = clone ($query);
    //     $specialDates = $clone->select('contracts.delivery_date')->groupBy('delivery_date')->pluck('delivery_date')->toArray();
    //     $specialDatesJson = json_encode($specialDates);
    //     if ($request->has('status')) {
    //         $query->where('contracts.status', $request->status);
    //     }
    //     if ($request->has('date_start')) {
    //         $query->whereDate('date_start', '>=', Carbon::parse($request->date_start));
    //     }

    //     if ($request->has('delivery_date')) {
    //         $query->whereDate('delivery_date', '=', Carbon::parse($request->delivery_date));
    //     }
    //     if ($request->has('date_end')) {
    //         $query->whereDate('date_end', '<=', Carbon::parse($request->date_end));
    //     }
    //     if ($request->has('product_name')) {
    //         $query->where('product_name', 'like', '%' . $request->product_name . '%');
    //     }
    //     if ($request->has('vp')) {
    //         $query->where('vp', 'like', '%' . $request->vp . '%');
    //     }
    //     $productNames = Contract::query()
    //         ->select('contracts.product_name')
    //         ->whereNotNull('contracts.product_name')
    //         ->whereRaw('TRIM(contracts.product_name) <> ""')
    //         ->latest()
    //         ->distinct() // Loại bỏ dữ liệu trùng lặp
    //         ->get();
    //     $vp = Contract::query()
    //         ->select('contracts.vp')
    //         ->whereNotNull('contracts.vp')
    //         ->whereRaw('TRIM(contracts.vp) <> ""')
    //         ->latest()
    //         ->distinct() // Loại bỏ dữ liệu trùng lặp
    //         ->get();
    //     $choice = $request->all();

    //     // Trả về dữ liệu JSON cho DataTable
    //     if ($request->ajax()) {
    //         return Datatables::of($query)
    //             ->addColumn('action', function ($row) {
    //                 $buttons = '
    //                             <div class="btn-group" style="width:5.2rem;margin-bottom:0.5rem;">
    //                                 <a class="btn btn-success" style="width:100%" href="' . route("contract.show", [$row->id]) . '">
    //                                     <i class="icon-phone"></i>
    //                                     </a>
    //                             </div>
    //                             <div class="btn-group" style="width:5.2rem;margin-bottom:0.5rem;" >
    //                                 <button type="button" style="width:100%" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    //                                     <i class="icon-menu9"></i>
    //                                 </button>

    //                                 <ul class="dropdown-menu dropdown-menu-right">';

    //                 if (Sentinel::hasAccess("contract.view")) {
    //                     $buttons .= '<li><a href="' . route("contract.show", [$row->id]) . '"><i class="fa fa-search"></i> ' . trans_choice("general.detail", 2) . '</a></li>';
    //                 }

    //                 if (Sentinel::hasAccess("contract.update")) {
    //                     $buttons .= '<li><a href="' . route("contract.edit", [$row->id]) . '"><i class="fa fa-edit"></i> ' . trans("general.edit") . '</a></li>';
    //                 }

    //                 if (Sentinel::hasAccess("contract.delete")) {
    //                     $buttons .= '<li><a href="' . route("contract.delete", [$row->id]) . '" class="delete"><i class="fa fa-trash"></i> ' . trans("general.delete") . '</a></li>';
    //                 }

    //                 // if (Sentinel::hasAccess("contract.delete")) {
    //                 //     $buttons .= '<li><a href="#" data-toggle="modal" data-target="#addCall" data-href="' . route("contract.call", [$row->id]) . '" class="addNewCall"><i class="fa fa-phone"></i> ' . trans("general.call_update") . '</a></li>';
    //                 // }

    //                 // if (Sentinel::hasAccess("call_history.view")) {
    //                 //     $buttons .= '<li><a href="' . route("call_history.index") . '?contract_id=' . $row->id . '"><i class="fa fa-bar-chart"></i> ' . trans("general.call_history") . '</a></li>';
    //                 // }

    //                 // if (Sentinel::hasAccess("field_history.view")) {
    //                 //     $buttons .= '<li><a href="#"><i class="fa fa-commenting"></i> ' . trans("general.field") . '</a></li>';
    //                 // }

    //                 $buttons .= '</ul></div>';
    //                 return $buttons;
    //             })
    //             ->editColumn('date_start', function ($row) {
    //                 $date_start = ($row->date_start != '0000-00-00') ? Carbon::parse($row->date_start)->format('d/m/Y') : 'Chưa có' . ' ' . 'BĐ';
    //                 $date_end = ($row->date_end != '0000-00-00') ? Carbon::parse($row->date_end)->format('d/m/Y') : 'Chưa có' . ' ' . 'KT';
    //                 $date = $date_start . '-' . $date_end;
    //                 return $date;
    //             })
    //             ->editColumn('customer_name', function ($row) {
    //                 $customer_name =  '<a href="' . route("contract.show", [$row->id]) . '">' . $row->customer_name . '</a>';
    //                 return $customer_name;
    //             })
    //             ->editColumn('status', function ($row) {
    //                 if (isset(config('constant.contract_status')[$row->status])) {
    //                     $statusColor = config('constant.contract_status_color')[$row->status];
    //                     $status = '<span class="label label-' . $statusColor . '">' . config("constant.contract_status")[$row->status] . '</span>';
    //                 } else {
    //                     $status = '<span class="label label-default">Unknown</span>'; // Trường hợp không khớp với giá trị nào trong config.
    //                 }
    //                 return $status;
    //             })
    //             ->editColumn('delivery_date', function ($row) {
    //                 $delivery_date = Carbon::parse($row->delivery_date)->format('d/m/Y');
    //                 return $delivery_date;
    //             })
    //             ->editColumn('total_value', function ($row) {
    //                 $total_value = number_format($row->total_value);
    //                 return $total_value;
    //             })

    //             ->editColumn('user_code', function ($row) use ($isUser, $hideStaffName) {
    //                 $agcode = '';

    //                 if (!$isUser) {
    //                     $agcode = $row->user_code;

    //                     if (!$hideStaffName) {
    //                         $agcode .= ' - ' . ($row->user ? ($row->user->first_name . ' ' . $row->user->last_name) : '');
    //                     }

    //                     $agcode .= ' - ' . $row->unit_code;
    //                 }

    //                 return $agcode;
    //             })
    //             ->filterColumn('user_code', function ($query, $keyword) {
    //                 $query->orWhere('users.user_code', 'LIKE', "%{$keyword}%")
    //                     ->orWhere('users.first_name', 'LIKE', "%{$keyword}%")
    //                     ->orWhere('users.unit_code', 'LIKE', "%{$keyword}%");
    //             })
    //             ->rawColumns(['action', 'customer_name', 'date_start', 'status', 'user_code', 'total_value', 'delivery_date'])
    //             ->make(true);
    //     }

    //     // Trả về view cho trình duyệt
    //     return view('contract.data', compact('hideStaffName', 'productNames', 'choice', 'isUser', 'vp', 'specialDatesJson'));
    // }
}
