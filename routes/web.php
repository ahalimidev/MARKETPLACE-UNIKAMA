<?php

use App\Http\Controllers\authControllers;
use App\Http\Controllers\dashboardControllers;
use App\Http\Controllers\keranjangControllers;
use App\Http\Controllers\menuControllers;
use App\Http\Controllers\tokoControllers;
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

Route::get('/', [dashboardControllers::class,'index'])->name('index');
Route::get('/pencarian',[dashboardControllers::class,'pencarian_produk'])->name('pencarian');
Route::get('/kategori/{nama}/{id}/', [menuControllers::class,'kategori_show'])->name('kategori');
Route::get('/kategori/{kategori}/{nama}/{id}', [menuControllers::class,'kategori_sub_show'])->name('kategorisub');
Route::get('/produk/detail/{nama}/{id}', [menuControllers::class,'Detail_Produk'])->name('detailproduk');

Route::get('/toko/{id_toko}', [tokoControllers::class,'index'])->name('toko');


Route::get('/login', [authControllers::class,'login'])->name('login');

Route::post('/login', [authControllers::class,'login_akses'])->name('login');

Route::get('/daftar', [authControllers::class,'daftar'])->name('daftar');
Route::post('/daftar', [authControllers::class,'daftar_akses'])->name('daftar');


Route::get('/lupa_password', [authControllers::class,'lupa_password'])->name('lupapassword');

Route::get('/profil', [authControllers::class,'profil'])->name('profil');
Route::get('/profil/detail', [authControllers::class,'profil_detail'])->name('profildetail');
Route::post('/profil/biodata', [authControllers::class,'profil_biodata'])->name('profildetailbiodata');
Route::post('/profil/foto', [authControllers::class,'profil_upload'])->name('profildetailfoto');
Route::post('/profil/password', [authControllers::class,'profil_password'])->name('profildetailpassword');

Route::get('/keranjang', [keranjangControllers::class,'index'])->name('keranjang');
Route::get('/keranjang/pembayaran/{id_transaksi_sementara}', [keranjangControllers::class,'bayar_keranjang'])->name('keranjangbayar');
Route::get('/keranjang/pembayaran/toko/{id_toko_penjual}', [keranjangControllers::class,'bayar_keranjang_all'])->name('keranjangbayarall');



Route::get('/keluar', [authControllers::class,'logout'])->name('logout');
Route::post('/simpan/produk/belanja', [keranjangControllers::class,'simpan'])->name('simpanproduk');
Route::post('/simpan/produk/belanja/stok', [keranjangControllers::class,'edit_stok_keranjang'])->name('stokkeranjang');
Route::post('/simpan/produk/belanja/hapus', [keranjangControllers::class,'hapus_stok_keranjang'])->name('hapuskeranjang');
Route::get('/update/produk/penawran/{id_transaksi_sementara}', [keranjangControllers::class,'penawaran'])->name('keranjangpenawaran');





