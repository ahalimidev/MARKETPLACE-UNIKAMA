<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class keranjangControllers extends Controller
{
    public function index(Request $request)
    {
        $id =  $request->session()->get('id_user');

        $menu_kategori = DB::select("SELECT * from kategori");
        $top_keranjang = DB::table('transaksi_sementara')
            ->select('toko_penjual.id_toko_penjual', 'toko_penjual.nama_toko')
            ->leftJoin('produk', 'produk.id_produk', '=', 'transaksi_sementara.id_produk')
            ->leftJoin('toko_penjual', 'produk.id_toko_penjual', '=', 'toko_penjual.id_toko_penjual')
            ->where('transaksi_sementara.id_user', $id)
            ->groupBy('toko_penjual.id_toko_penjual')->get();
        $hasil = array();
        for ($i = 0; $i < count($top_keranjang); $i++) {
            $hasil_keranjang = array();
            $hasil_keranjang['id_toko_penjual'] = $top_keranjang[$i]->id_toko_penjual;
            $hasil_keranjang['nama_toko'] = $top_keranjang[$i]->nama_toko;

            $keranjang = DB::table('transaksi_sementara')->select('transaksi_sementara.id_transaksi_sementara', 'produk.id_produk', 'toko_penjual.id_toko_penjual', 'produk.nama_produk', 'produk.foto_produk', 'transaksi_sementara.harga_produk', 'transaksi_sementara.stok_produk', 'transaksi_sementara.berat_produk', 'transaksi_sementara.diskon_produk', 'transaksi_sementara.penawaran_produk', 'toko_penjual.nama_toko', 'toko_penjual.nomor_hp_toko', 'transaksi_sementara.status_transaksi', 'transaksi_sementara.penawaran_produk')
                ->leftJoin('produk', 'produk.id_produk', '=', 'transaksi_sementara.id_produk')
                ->leftJoin('toko_penjual', 'produk.id_toko_penjual', '=', 'toko_penjual.id_toko_penjual')
                ->where('transaksi_sementara.id_user', $id)
                ->where('toko_penjual.id_toko_penjual', $top_keranjang[$i]->id_toko_penjual)->get();

            $hasil_keranjang['data'] = array();
            $sum = 0;
            for ($a = 0; $a < count($keranjang); $a++) {
                $hasil_detail = array();
                $hasil_detail['id_transaksi_sementara'] = $keranjang[$a]->id_transaksi_sementara;
                $hasil_detail['id_produk'] = $keranjang[$a]->id_produk;
                $hasil_detail['id_toko_penjual'] = $keranjang[$a]->id_toko_penjual;
                $hasil_detail['nama_produk'] = $keranjang[$a]->nama_produk;
                $hasil_detail['penawaran_produk'] = $keranjang[$a]->penawaran_produk;
                $hasil_detail['foto_produk'] = $keranjang[$a]->foto_produk;
                $hasil_detail['harga_produk'] = $keranjang[$a]->harga_produk;
                $hasil_detail['stok_produk'] = $keranjang[$a]->stok_produk;
                $hasil_detail['berat_produk'] = $keranjang[$a]->berat_produk;
                $hasil_detail['diskon_produk'] = $keranjang[$a]->diskon_produk;
                $hasil_detail['penawaran_produk'] = $keranjang[$a]->penawaran_produk;
                $hasil_detail['nama_toko'] = $keranjang[$a]->nama_toko;
                $hasil_detail['nomor_hp_toko'] = $keranjang[$a]->nomor_hp_toko;
                $hasil_detail['status_transaksi'] = $keranjang[$a]->status_transaksi;
                if($keranjang[$a]->penawaran_produk == null){
                    $sum+= ($keranjang[$a]->diskon_produk / 100) * ($keranjang[$a]->harga_produk * $keranjang[$a]->stok_produk);
                }else{
                    $sum+= $keranjang[$a]->penawaran_produk;
                }
                array_push($hasil_keranjang['data'], $hasil_detail);

            }

            $hasil_keranjang['total'] = $sum;
            array_push($hasil, $hasil_keranjang);
        }
        $data = $request->query('keyword');

        if ($data != null) {
            $qx = "keyword=" . $data;
            return redirect()->route('pencarian', $qx);
        }
        return view('produk.keranjang', compact('menu_kategori', 'hasil'));
    }

    public function simpan(Request $request)
    {

        $data = $request->query('keyword');

        if ($data != null) {
            $qx = "keyword=" . $data;
            return redirect()->route('pencarian', $qx);
        }

        $id =  $request->session()->get('id_user');
        $stok = $request->stok;
        $id_produk = $request->id_produk;
        $status = $request->status;

        $cek = DB::table('transaksi_sementara')->select('*')
            ->where('id_user', $id)
            ->where('id_produk', $id_produk)
            ->whereIn('status_transaksi', ['keranjang', 'penawaran'])->first();
        if ($cek) {
            $hasil = $cek->stok_produk + $stok;
            $produk = DB::table('produk')->select('*')->where('id_produk', $id_produk)->first();
            DB::update('update transaksi_sementara set stok_produk = ?, status_transaksi=? where id_transaksi_sementara = ?', [$hasil, $status, $cek->id_transaksi_sementara]);
        } else {
            $produk = DB::table('produk')->select('*')->where('id_produk', $id_produk)->first();
            DB::insert('INSERT INTO transaksi_sementara (id_user,id_produk,harga_produk,stok_produk,berat_produk,diskon_produk,status_transaksi) VALUES (?, ?, ?, ?, ?, ?, ?)', [$id, $id_produk, $produk->harga_produk, $stok, $produk->berat_produk, $produk->diskon_produk, $status]);
        }
        return redirect()->route('keranjang');
    }

    public function edit_stok_keranjang(Request $request)
    {

        if ($request->ajax()) {
            $stok = $request->stok;
            $id_transaksi_sementara = $request->id_transaksi_sementara;

            return DB::update('update transaksi_sementara set stok_produk = ? where id_transaksi_sementara = ?', [$stok, $id_transaksi_sementara]);
        }
    }
    public function hapus_stok_keranjang(Request $request)
    {

        if ($request->ajax()) {
            $id_transaksi_sementara = $request->id_transaksi_sementara;
            return DB::delete('delete from transaksi_sementara where id_transaksi_sementara = ?', [$id_transaksi_sementara]);
        }
    }

    public function bayar_keranjang(Request $request,$id_toko){
        $menu_kategori = DB::select("SELECT * from kategori");

         $id =  $request->session()->get('id_user');
         $data = $request->query('keyword');

         if ($data != null) {
             $qx = "keyword=" . $data;
             return redirect()->route('pencarian', $qx);
         }
         return view('produk.keranjang_bayar', compact('menu_kategori'));
    }

}
