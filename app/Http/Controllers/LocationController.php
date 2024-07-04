<?php

namespace App\Http\Controllers;

use App\Models\KhuNuoi;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
class LocationController extends Controller
{
    public function __construct()
    {
        // Apply middleware to all controller methods
        $this->middleware('auth.check');
    }
    public function save_vi_tri(Request $request){
        // $this->authorize('add.khu');
        $data = $request->all();
        //dd($data);
        $khu = new Location();
        $lay_ten_khu = KhuNuoi::where('ma_khu',$data['ma_khu'])->first();
        $khu->ma_khu = $data['ma_khu'];
        $khu->latitude = $data['latitude'];
        $khu->longitude = $data['longitude'];
        if(($data['ma_khu'] =='') || ($data['latitude'] =='') || ($data['longitude'] =='')){
            Session::put('error','Vui lòng nhập đầy đủ thông tin!!!.');
            return Redirect::to('all-khu-nuoi');
        }else{
            $check_vi_tri = Location::get();
            foreach($check_vi_tri as $check){
                if($check->ma_khu == $data['ma_khu']){
                    Session::put('error',''.$lay_ten_khu->ten_khu.' đã được ghim vị trí trước đó!!!.');
                    return Redirect::to('all-khu-nuoi');
                }
            }
        }
        $khu->save();
        Session::put('message','Ghim vị trí '.$lay_ten_khu->ten_khu.' nuôi thành công.');
        return Redirect::to('all-khu-nuoi');
    }
}
