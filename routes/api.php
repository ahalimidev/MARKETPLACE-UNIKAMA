<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\wilyahControllers;
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
