<?php
use App\Http\Controllers\CLogin;
use App\Http\Controllers\CDashboard;
use App\Http\Controllers\CMarketplace;
use App\Http\Controllers\CKurir;
use App\Http\Controllers\CPengiriman;
use App\Http\Controllers\CUser;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [CLogin::class,'index'])->middleware("guest");
Route::post('/auth', [CLogin::class,'authenticate']);
Route::get('/logout', [CLogin::class,'logout']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [CDashboard::class,'index'])->name('dashboard');

    Route::get('/marketplace', [CMarketplace::class,'index'])->name('marketplace-index');
    Route::get('/marketplace/data', [CMarketplace::class,'data']);
    Route::get('/marketplace/create', [CMarketplace::class,'create']);
    Route::post('/marketplace/create-save', [CMarketplace::class,'create_save']);
    Route::get('/marketplace/show/{id}', [CMarketplace::class,'show']);
    Route::get('/marketplace/detail/{id}', [CMarketplace::class,'detail']);
    Route::post('/marketplace/show-save/{id}', [CMarketplace::class,'show_save']);
    Route::get('/marketplace/delete/{id}', [CMarketplace::class,'delete']);

    Route::get('/kurir', [CKurir::class,'index'])->name('kurir-index');
    Route::get('/kurir/data', [CKurir::class,'data']);
    Route::get('/kurir/create', [CKurir::class,'create']);
    Route::post('/kurir/create-save', [CKurir::class,'create_save']);
    Route::get('/kurir/show/{id}', [CKurir::class,'show']);
    Route::get('/kurir/detail/{id}', [CKurir::class,'detail']);
    Route::post('/kurir/show-save/{id}', [CKurir::class,'show_save']);
    Route::get('/kurir/delete/{id}', [CKurir::class,'delete']);

    Route::get('/pengiriman', [CPengiriman::class,'index'])->name('pengiriman-index');
    Route::get('/pengiriman/data', [CPengiriman::class,'data']);
    Route::get('/pengiriman/create', [CPengiriman::class,'create']);
    Route::post('/pengiriman/create-save', [CPengiriman::class,'create_save']);
    Route::get('/pengiriman/show/{id}', [CPengiriman::class,'show']);
    Route::get('/pengiriman/detail/{id}', [CPengiriman::class,'detail']);
    Route::post('/pengiriman/show-save/{id}', [CPengiriman::class,'show_save']);
    Route::get('/pengiriman/delete/{id}', [CPengiriman::class,'delete']);
    Route::post('/pengiriman/print', [CPengiriman::class,'print']);
    Route::post('/pengiriman/verifikasi', [CPengiriman::class,'verifikasi']);

    Route::get('/user', [CUser::class,'index'])->name('user-index');
    Route::get('/user/data', [CUser::class,'data']);
    Route::get('/user/create', [CUser::class,'create']);
    Route::post('/user/create-save', [CUser::class,'create_save']);
    Route::get('/user/show/{id}', [CUser::class,'show']);
    Route::post('/user/show-save/{id}', [CUser::class,'show_save']);
    Route::get('/user/delete/{id}', [CUser::class,'delete']);
});
