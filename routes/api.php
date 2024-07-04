<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AoNuoiApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login',[ApiController::class,'login']);
Route::post('/logout',[ApiController::class,'logout']);
//moi-truong
Route::get('/all-moi-truong',[ApiController::class,'moi_truong']);
Route::post('/save-moi-truong',[ApiController::class,'save_moi_truong']);
Route::post('/update-moi-truong/{id_moi_truong}',[ApiController::class,'update_moi_truong']);
//ao-nuoi
Route::get('/all-ao-nuoi',[ApiController::class,'all_ao_nuoi']);
Route::post('/save-ao',[ApiController::class,'save_ao']);
Route::post('/update-ao-nuoi/{ma_ao}',[ApiController::class,'update_ao']);
