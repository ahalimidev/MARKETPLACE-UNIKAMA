<?php

use App\Http\Controllers\keranjangControllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\wilyahControllers;
use App\Http\Controllers\rajaongkirControllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/wilyah_provinsi', [wilyahControllers::class,'provinsi']);
Route::get('/wilyah_kabupaten/{id}', [wilyahControllers::class,'kabupaten']);
Route::get('/wilyah_kecamatan/{id}', [wilyahControllers::class,'kecamatan']);
Route::get('/wilyah_desa/{id}', [wilyahControllers::class,'desa']);

Route::group(['prefix' => 'gateway'], function () {
    Route::get('/provinsi',  [rajaongkirControllers::class,'provinsi']);
    Route::get('/kota',  [rajaongkirControllers::class,'kota']);
    Route::get('/kotaId',  [rajaongkirControllers::class,'kotaId']);
    Route::get('/kecamatan',  [rajaongkirControllers::class,'kecamatan']);
    Route::get('/kecamatanId',  [rajaongkirControllers::class,'kecamatanId']);
});

Route::post('/ongkir', [rajaongkirControllers::class,'ongkir']);
Route::post('/transaksi/one', [keranjangControllers::class,'simpan_transaksi']);
