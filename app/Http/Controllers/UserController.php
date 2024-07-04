<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Support\Facades\Hash;
use Throwable;
use App\Http\Middleware\CheckAuth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function render($request, Throwable $exception) {
        // Ensure $user is initialized even if user is not authenticated
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', compact(''), 404);
        }

        if ($exception instanceof AccessDeniedHttpException || $exception instanceof AuthorizationException) {
            $user = Auth::user();
            return response()->view('errors.403', compact('user'), 403);
        }

        return parent::render($request, $exception);
    }
    public function user_login(Request $request){
        $credentials = $request->only('email', 'password');
        //dd($credentials);
        if (Auth::attempt($credentials)) {
            // Đăng nhập thành công
            $user = Auth::user();
            Session::put('message', 'Đăng nhập thành công');
            return redirect()->route('trang-chu',[
                'user'=> $user,
            ]);
        }else {
            // Đăng nhập thất bại
            Session::put('message', 'Đăng nhập thất bại, kiểm tra lại tài khoản và mật khẩu!!!');
            return redirect('/login');
        }
    }
    public function user_logout(){
        Auth::logout();
        Session::put('message','Đăng xuất thành công');
        return redirect('/login');
    }
    public function user_register(Request $request){
        $data = $request->all();
        $new_user = new User();
        $new_user->name = $data['name'];
        $new_user->email = $data['email'];
        $new_user->password = $data['password'];
        $userExists = User::where('email', $data['email'])->exists();
        if($data['password'] != $data['retype_password']){
            Session::put('message','Mật khẩu không trùng khớp!!!.');
            return redirect('/register');
        }elseif($userExists){
            Session::put('message','Tài khoản đã tồn tại!!!.');
            return redirect('/register');
        }else{
            $new_user->save();
            Auth::login($new_user);
            $user = Auth::login($new_user);
            Session::put('message','Đăng ký thành công');
            return redirect()->route('trang-chu',[
                'user' => $user,
            ]);
        }
    }
    public function admin_add_user(Request $request){
        $this->middleware(CheckAuth::class);
        $data = $request->all();
        $new_user = new User();
        $new_user->name = $data['name'];
        $new_user->email = $data['email'];
        $new_user->password = $data['password'];
        $userExists = User::where('email', $data['email'])->exists();
        if($data['name'] == '' || $data['email'] == '' || $data['password'] == '' || $data['retype_password'] == ''){
            Session::put('error','Vui lòng điền đầy đủ thông tin.');
            return redirect('quan-ly-tai-khoan');
        }elseif($data['password'] != $data['retype_password']){
            Session::put('error','Mật khẩu không trùng khớp.');
            return redirect('quan-ly-tai-khoan');
        }elseif($userExists){
            Session::put('error','Tài khoản đã tồn tại.');
            return redirect('quan-ly-tai-khoan');
        }else{
            $new_user->save();
            Session::put('message','Thêm user mới thành công.');
            return redirect('quan-ly-tai-khoan');
        }
    }
    public function all_user(Request $request){
        $this->middleware(CheckAuth::class);
        $user = Auth::user();
        // Check if the authenticated user has the 'admin' role
        $adminRole = Role::where('name', 'admin')->first();
        if (!$user->roles->contains($adminRole)){
            return view('errors.403');
        }
        //lay danh sach bo loc
        $lay_user = User::orderBy('id','DESC')->get();
        //datatable
        $all_user = User::query()->orderBy('id','DESC');
        if($request->has('lay_user_loc') && $request->lay_user_loc != null){
            $all_user->where('email',$request->lay_user_loc);
        }
        if($request->ajax()){
            return DataTables::of($all_user)
            ->addColumn('Action', function($row){
                return'
                    <div style="display:flex; border:none;grid-gap:5px;">
                        <div class="dropdown">
                            <button class="icon-dropdown">
                                <i class="fa fa-fw fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-content">
                                <a href="/phan-vai-tro/'.$row->id.'">
                                    Phân vai trò
                                </a>
                                <a href="/phan-quyen/'.$row->id.'">
                                    Phân quyền
                                </a>
                                <a href="/edit-password/'.$row->id.'">
                                    Cập nhật mật khẩu
                                </a>
                            </div>
                        </div>
                    </div>
                    ';
            } )->rawColumns(['Action'])
            ->make(true);
        }
        return view('admin.user.all_user',[
            'user' => $user,
            'lay_user' => $lay_user,
            'all_user' => $all_user
        ]);
    }
    public function them_quyen(Request $request, $id){
       $this->middleware(CheckAuth::class);
       $data = $request->all();
       $user = User::find($id);
       $role_id = $user->roles->first()->id;
       $role = Role::find($role_id);
       //dd($data['permission']);
       $role->syncPermissions($data['permission']);

       Session::put('message','Thêm quyền cho user thành công.');
       return redirect()->back();
    }
    public function phan_quyen($id){
        $this->middleware(CheckAuth::class);
        $user = Auth::user();
        // Check if the authenticated user has the 'admin' role
        $adminRole = Role::where('name', 'admin')->first();
        if (!$user->roles->contains($adminRole)){
            return view('errors.403');
        }
        $lay_user = User::find($id);
        // // $name_roles = $user->roles->first()->name;
        // //dd($name_roles);
        $permission = Permission::orderBy('id','DESC')->get();
        $name_roles = $lay_user->roles->first()->name;
        $get_permission_via_role = $lay_user->getPermissionsViaRoles();
        // $role = Role::orderBy('id','DESC')->get();
        // $all_column_roles = $user->roles->first();
        return view('admin.user.phan_quyen',compact('user','lay_user','name_roles','permission','get_permission_via_role'));
    }
    public function save_quyen(Request $request){
        $this->middleware(CheckAuth::class);
        $data = $request->all();
        Permission::create([
            'name'=>$data['ten_quyen'],
            'describe'=>$data['mo_ta'],
        ]);
        Session::put('message','Thêm quyền mới thành công.');
        return redirect()->back();
    }
    public function them_vai_tro(Request $request, $id){
        $this->middleware(CheckAuth::class);
        $data = $request->all();
        $user = User::find($id);
        $user->syncRoles($data['role']);
        Session::put('message','Thêm vai trò cho user thành công.');
        return redirect()->back();
     }
    public function phan_vai_tro($id){
        $this->middleware(CheckAuth::class);
        $user = Auth::user();
        // Check if the authenticated user has the 'admin' role
        $adminRole = Role::where('name', 'admin')->first();
        if (!$user->roles->contains($adminRole)){
            return view('errors.403');
        }
        $lay_user = User::find($id);
        // $name_roles = $user->roles->first()->name;
        //dd($name_roles);
        $permission = Permission::orderBy('id','DESC')->get();
        $role = Role::orderBy('id','DESC')->get();
        $all_column_roles = $lay_user->roles->first();
        return view('admin.user.phan_vai_tro',compact('user','lay_user','role','all_column_roles','permission'));
    }
    public function save_vai_tro(Request $request){
        $this->middleware(CheckAuth::class);
        $data = $request->all();
        Role::create(['name'=>$data['ten_vai_tro']]);
        Session::put('message','Thêm vai trò mới thành công.');
        return redirect()->back();
    }
    public function edit_password(Request $request, $id ){
        $this->middleware(CheckAuth::class);
        $user = Auth::user();
        // Check if the authenticated user has the 'admin' role
        $adminRole = Role::where('name', 'admin')->first();
        if (!$user->roles->contains($adminRole)){
            return view('errors.403');
        }
        // $lay_user = User::where('id',$id)->first();
        //dd($lay_user);
        return view('admin.user.edit_password',[
            'id' => $id,
            'user' => $user,
        ]);
    }
    public function update_password(Request $request, $id ){
        $this->middleware(CheckAuth::class);
        $user = Auth::user();
        $lay_user = User::where('id',$id)->first();
        $password = $request->password;
        $re_password = $request->re_password;
        if($lay_user){
            if($password == '' || $re_password == ''){
                Session::put('message','Vui lòng nhập đầy đủ thông tin.');
                return redirect('quan-ly-tai-khoan');
            }
            if($password == $re_password){
                $hashedPassword = Hash::make($password);
                $lay_user->update([
                    'password' =>  $hashedPassword,
                ]);
                Session::put('message','Cập nhật mật khẩu tài khoản '.$lay_user->email.' thành công.');
                return redirect('quan-ly-tai-khoan');
            }else{
                Session::put('message','Xác nhận mật khẩu không trùng khớp.');
                return redirect('quan-ly-tai-khoan');
            }
        }else{
            Session::put('message','Người dùng không tồn tại.');
                return redirect('quan-ly-tai-khoan');
        }

    }
}
