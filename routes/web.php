<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KhuNuoiController;
use App\Http\Controllers\AoNuoiController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MoiTruongController;
use App\Http\Controllers\NhatKyController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VatTuController;
use App\Http\Controllers\VuNuoiController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/a', function () {
    return view('login_register.login_test');
});

Route::get('/', function () {
    return view('login_register.ad_login');
})->name('login');
Route::get('/login', function () {
    return view('login_register.ad_login');
});
// Route::get('/',[UserController::class,'user_login']);
Route::post('/user-login',[UserController::class,'user_login']);

Route::get('/trang-chu',[AdminController::class,'trang_chu'])->name('trang-chu');

Route::get('/register', function () {
    return view('login_register.ad_register');
});
Route::post('/user-register',[UserController::class,'user_register']);
Route::post('/admin-add-user',[UserController::class,'admin_add_user']);
Route::get('/user-logout',[UserController::class,'user_logout']);

// Route::get('/map', 'AdminController@indexMap');
// Route::post('/map/add', 'AdminController@addLocation');

Route::get('/chi-tiet-ao',[AdminController::class,'chi_tiet_ao']);
Route::get('/delete-chi-tiet-ao/{id_chi_tiet_ao}',[AdminController::class,'delete_chi_tiet_ao']);
//reset loc
Route::get('/loc-bo-loc',[AdminController::class,'loc_bo_loc'])->name('loc-bo-loc');
Route::get('/loc-chi-tiet-ao',[AdminController::class,'chi_tiet_ao'])->name('thiet-lap.loc_chi_tiet_ao');

// Route::get('/thiet-lap-ao',[AoNuoiController::class,'ao_nuoi'])->name('thiet-lap.ao');
// Route::get('/thiet-lap-vu',[VuNuoiController::class,'vu_nuoi'])->name('thiet-lap.vu');
// Route::get('/thiet-lap-vat-tu',[VatTuController::class,'vat_tu'])->name('thiet-lap.vat_tu');
// Route::get('/thiet-lap-nhat-ky',[AdminController::class,'nhat_ky'])->name('thiet-lap.nhat_ky');

Route::get('/delete-khu/{ma_khu}',[KhuNuoiController::class,'delete_khu']);
Route::get('/delete-ao/{ma_ao}',[AoNuoiController::class,'delete_ao']);
Route::get('/delete-vu/{ma_vu}',[VuNuoiController::class,'delete_vu']);
Route::get('/delete-vat-tu/{ma_vat_tu}',[VatTuController::class,'delete_vat_tu']);

Route::get('/edit-khu/{ma_khu}',[KhuNuoiController::class,'edit_khu']);
Route::get('/edit-ao/{ma_ao}',[AoNuoiController::class,'edit_ao']);
Route::get('/edit-vu/{ma_vu}',[VuNuoiController::class,'edit_vu']);
Route::get('/edit-vat-tu/{ma_vat_tu}',[VatTuController::class,'edit_vat_tu']);
Route::get('/nhap-vat-tu/{ma_vat_tu}',[VatTuController::class,'nhap_vat_tu']);
Route::post('/save-nhap-vat-tu/{ma_vat_tu}',[VatTuController::class,'save_nhap_vat_tu']);

Route::post('/update-khu/{ma_khu}',[KhuNuoiController::class,'update_khu']);
Route::post('/update-ao/{ma_ao}',[AoNuoiController::class,'update_ao']);
Route::post('/update-vu/{ma_vu}',[VuNuoiController::class,'update_vu']);
Route::post('/update-vat-tu/{ma_vat_tu}',[VatTuController::class,'update_vat_tu']);

Route::post('/save-khu-nuoi',[KhuNuoiController::class,'save_khu_nuoi']);
Route::post('/save-ao-nuoi',[AoNuoiController::class,'save_ao_nuoi']);
Route::post('/save-vu-nuoi',[VuNuoiController::class,'save_vu_nuoi']);
Route::post('/save-vat-tu',[VatTuController::class,'save_vat_tu'])->name('save-vat-tu');
//add
Route::get('/add-chi-tiet-ao/{ma_ao}',[AdminController::class,'add_chi_tiet_ao']);

Route::post('/save-chi-tiet-ao/{ma_ao}',[AdminController::class,'save_chi_tiet_ao']);
Route::get('/edit-chi-tiet-ao/{id_chi_tiet_ao}',[AdminController::class,'edit_chi_tiet_ao']);
Route::post('/update-chi-tiet-ao/{id_chi_tiet_ao}',[AdminController::class,'update_chi_tiet_ao']);

Route::get('/moi-truong',[MoiTruongController::class,'moi_truong'])->name('all.moi_truong');
Route::get('/thiet-lap-moi-truong',[MoiTruongController::class,'moi_truong'])->name('thiet-lap.moi_truong');
Route::get('/add-moi-truong/{id_chi_tiet_ao}',[MoiTruongController::class,'add_moi_truong']);
Route::post('/save-moi-truong/{id_chi_tiet_ao}',[MoiTruongController::class,'save_moi_truong']);
Route::get('/edit-moi-truong/{id_moi_truong}',[MoiTruongController::class,'edit_moi_truong']);
Route::post('/update-moi-truong/{id_moi_truong}',[MoiTruongController::class,'update_moi_truong']);

Route::get('/nhat-ky',[NhatKyController::class,'nhat_ky'])->name('thiet-lap.nhat_ky');
Route::get('/add-nhat-ky/{id_chi_tiet_ao}',[NhatKyController::class,'add_nhat_ky']);
Route::get('/add-nhat-ky/{id}',[NhatKyController::class,'add_nhat_ky'])->name('add-nhat-ky');
Route::get('/add-moi-truong/{id}',[MoiTruongController::class,'add_moi_truong'])->name('add-moi-truong');
Route::post('/save-nhat-ky/{id_chi_tiet_ao}',[NhatKyController::class,'save_nhat_ky']);
Route::get('/delete-nhat-ky/{id_nhat_ky}',[NhatKyController::class,'delete_nhat_ky']);


Route::get('/chi-tiet-mot-ao',[AdminController::class,'chi_tiet_mot_ao'])->name('thiet-lap.mot_ao');

Route::get('/all-khu-nuoi',[KhuNuoiController::class,'all_khu_nuoi'])->name('all.khu');
Route::get('/thiet-lap-khu',[KhuNuoiController::class,'all_khu_nuoi'])->name('thiet-lap.khu');

Route::get('/all-vu-nuoi',[VuNuoiController::class,'all_vu_nuoi'])->name('all.vu');
Route::get('/thiet-lap-vu',[VuNuoiController::class,'all_vu_nuoi'])->name('thiet-lap.vu');

Route::get('/all-ao-nuoi',[AoNuoiController::class,'all_ao_nuoi'])->name('all.ao');
Route::get('/thiet-lap-ao',[AoNuoiController::class,'all_ao_nuoi'])->name('thiet-lap.ao');
//
Route::get('/update-ao-nuoi',[AdminController::class,'chi_tiet_ao'])->name('update-ao-nuoi');

Route::get('/all-vat-tu',[VatTuController::class,'all_vat_tu'])->name('all.vat_tu');
Route::get('/thiet-lap-vat-tu',[VatTuController::class,'all_vat_tu'])->name('thiet-lap.vat_tu');
Route::get('/lich-su-nhap-vat-tu/{ma_vat_tu}',[VatTuController::class,'lich_su_nhap_vat_tu'])->name('lich_su_nhap_vat_tu');
Route::get('/thiet-lap-ls-vat-tu',[VatTuController::class,'lich_su_nhap_vat_tu'])->name('thiet-lap.lich_su_nhap_vat_tu');

Route::get('/all-khach-hang',[KhachHangController::class,'all_khach_hang'])->name('all.khach_hang');
Route::get('/thiet-lap-khach-hang',[KhachHangController::class,'all_khach_hang'])->name('thiet-lap.khach_hang');
Route::post('/save-khach-hang',[KhachHangController::class,'save_khach_hang']);
Route::get('/edit-khach-hang/{id_khach_hang}',[KhachHangController::class,'edit_khach_hang']);
Route::post('/update-khach-hang/{id_khach_hang}',[KhachHangController::class,'update_khach_hang']);
Route::get('/delete-khach-hang/{id_khach_hang}',[KhachHangController::class,'delete_khach_hang']);

Route::get('/all-bao-cao-ao',[AdminController::class,'all_bao_cao_ao'])->name('all.all_bao_cao_ao');
Route::get('/bao-cao-ao/{ma_ao}/{ma_khu}/{ma_vu}',[AdminController::class,'bao_cao_ao'])->name('all.bao_cao_ao');
Route::get('/thet-lap-bao-cao-ao',[AdminController::class,'bao_cao_ao'])->name('thiet-lap.bao_cao_ao');
Route::get('/all-chi-tiet-mot-ngay/{ma_ao}/{ma_khu}/{ma_vu}/{ngay}',[AdminController::class,'all_chi_tiet_mot_ngay'])->name('all.all_chi_tiet_mot_ngay');

//ban-tom
Route::post('/save-ban-tom/{ma_ao}/{ma_khu}/{ma_vu}',[AdminController::class,'save_ban_tom']);
Route::post('/tinh-adg/{ma_ao}/{ma_khu}/{ma_vu}',[AdminController::class,'tinh_adg']);
Route::post('/save-chiet-tom/{ma_ao}',[AdminController::class,'chiet_tom']);
Route::post('/save-sang-tom/{ma_ao}',[AdminController::class,'sang_tom']);
Route::post('/save-gia-tom',[AdminController::class,'save_gia_tom']);

Route::get('/lich-su-nuoi/{ao_cha}',[AdminController::class,'lich_su_nuoi'])->name('all.lich_su_nuoi');
Route::get('/quan-ly-tai-khoan',[UserController::class,'all_user']);
Route::get('/thiet-lap-user',[UserController::class,'all_user'])->name('thiet-lap.user');
Route::get('/phan-quyen/{id}',[UserController::class,'phan_quyen']);
Route::post('/them-quyen/{id}',[UserController::class,'them_quyen']);
Route::get('/phan-vai-tro/{id}',[UserController::class,'phan_vai_tro']);
Route::post('/them-vai-tro/{id}',[UserController::class,'them_vai_tro']);
Route::post('/save-quyen',[UserController::class,'save_quyen']);
Route::post('/save-vai-tro',[UserController::class,'save_vai_tro']);
Route::get('/impersonate/user/{id}',[UserController::class,'impersonate'])->middleware('impersonate');

Route::get('/unactive-vu/{ma_vu}',[VuNuoiController::class,'unactive_vu']);
Route::get('/active-vu/{ma_vu}',[VuNuoiController::class,'active_vu']);
Route::get('/unactive-khu/{ma_khu}',[KhuNuoiController::class,'unactive_khu']);
Route::get('/active-khu/{ma_khu}',[KhuNuoiController::class,'active_khu']);

Route::get('password-reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password-email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('password-reset-update', [ResetPasswordController::class, 'reset_update_password'])->name('password.reset.update');
Route::get('password-reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

Route::get('/xuat-lich-su-nuoi/{ao_cha}',[AdminController::class,'xuat_lich_su_nuoi']);
Route::get('/edit-password/{id}',[UserController::class,'edit_password']);
Route::post('/update-password/{id}',[UserController::class,'update_password']);
Route::get('/back',[AdminController::class,'back']);
Route::get('/ban-tom',[AdminController::class,'ban_tom']);
Route::post('/save-vi-tri',[LocationController::class,'save_vi_tri']);
// Route::get('/api/all-ao-nuoi',[ApiController::class,'all_ao_nuoi']);
