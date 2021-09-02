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
            ->whereNotIn("transaksi_sementara.status_transaksi", ["batal"])
            ->where('transaksi_sementara.id_user', $id)
            ->groupBy('toko_penjual.id_toko_penjual')->get();
        $hasil = array();
        for ($i = 0; $i < count($top_keranjang); $i++) {
            $hasil_keranjang = array();
            $hasil_keranjang['id_toko_penjual'] = $top_keranjang[$i]->id_toko_penjual;
            $hasil_keranjang['nama_toko'] = $top_keranjang[$i]->nama_toko;

            $keranjang = DB::table('transaksi_sementara')->select('transaksi_sementara.id_transaksi_sementara', 'produk.id_produk', 'toko_penjual.id_toko_penjual', 'produk.nama_produk', 'produk.foto_produk', 'transaksi_sementara.harga_produk', 'transaksi_sementara.stok_produk', 'transaksi_sementara.berat_produk', 'transaksi_sementara.diskon_produk', 'transaksi_sementara.penawaran_produk', 'toko_penjual.nama_toko', 'toko_penjual.nomor_hp_toko', 'transaksi_sementara.status_transaksi', 'transaksi_sementara.tanggal_penawaran')
                ->leftJoin('produk', 'produk.id_produk', '=', 'transaksi_sementara.id_produk')
                ->leftJoin('toko_penjual', 'produk.id_toko_penjual', '=', 'toko_penjual.id_toko_penjual')
                ->whereNotIn("transaksi_sementara.status_transaksi", ["batal"])
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
                $hasil_detail['tanggal_penawaran'] = $keranjang[$a]->tanggal_penawaran;
                $hasil_detail['nama_toko'] = $keranjang[$a]->nama_toko;
                $hasil_detail['nomor_hp_toko'] = $keranjang[$a]->nomor_hp_toko;
                $hasil_detail['status_transaksi'] = $keranjang[$a]->status_transaksi;

                if ($keranjang[$a]->penawaran_produk == null) {
                    if ($keranjang[$a]->diskon_produk == null || $keranjang[$a]->diskon_produk == 0) {
                        $sum += ($keranjang[$a]->harga_produk * $keranjang[$a]->stok_produk);
                    } else {
                        $sum += ($keranjang[$a]->diskon_produk / 100) * ($keranjang[$a]->harga_produk * $keranjang[$a]->stok_produk);
                    }
                } else {
                    $sum += $keranjang[$a]->penawaran_produk;
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

    public function penawaran($id_transaksi_sementara)
    {
        DB::update('update transaksi_sementara set status_transaksi = ? where id_transaksi_sementara = ?', ["penawaran", $id_transaksi_sementara]);
        return redirect()->route('keranjang');
    }

    public function hapus_stok_keranjang(Request $request)
    {

        if ($request->ajax()) {
            $id = $request->id_transaksi_sementara;

            $cek = collect(DB::select('select * from transaksi_sementara where id_transaksi_sementara = ?  ', [$id]))->first();

            if ($cek->penawaran_produk != null || $cek->penawaran_produk != 0) {
                $produk = collect(DB::select('select * from produk where id_produk = ? ', [$cek->id_produk]))->first();
                if (DB::table('transaksi_sementara')
                ->where('id_transaksi_sementara', $id)
                ->whereNotIn("status_transaksi", ["batal"])
                ->update(['status_transaksi' => "batal", 'catatan_batal' => "oleh pembeli"])) {
                    //redirect dengan pesan sukses
                    $kurang_stok = $produk->stok_produk + $cek->stok_produk;
                    DB::table('produk')->where('id_produk', $cek->id_produk)->update(['stok_produk' => $kurang_stok]);
                    return true;
                } else {
                    //redirect dengan pesan error
                    return true;
                }
            } else {
                if (DB::table('transaksi_sementara')
                ->where('id_transaksi_sementara', $id)
                ->whereNotIn("status_transaksi", ["batal"])
                ->update(['status_transaksi' => "batal", 'catatan_batal' => "oleh pembeli"])) {
                    //redirect dengan pesan sukses

                    return true;
                } else {
                    //redirect dengan pesan error
                    return true;
                }
            }
        }
    }

    public function bayar_keranjang(Request $request, $id_transaksi_sementara)
    {
        $menu_kategori = DB::select("SELECT * from kategori");

        $id =  $request->session()->get('id_user');
        $data = $request->query('keyword');
        $sum = 0;
        $toko = DB::table('transaksi_sementara')
            ->select('toko_penjual.id_toko_penjual', 'toko_penjual.nama_toko')
            ->leftJoin('produk', 'produk.id_produk', '=', 'transaksi_sementara.id_produk')
            ->leftJoin('toko_penjual', 'produk.id_toko_penjual', '=', 'toko_penjual.id_toko_penjual')
            ->where('transaksi_sementara.id_transaksi_sementara', $id_transaksi_sementara)->where('transaksi_sementara.id_user', $id)
            ->groupBy('toko_penjual.id_toko_penjual')->first();

        $kurir = DB::table('kurir_toko_penjual')
            ->select('kurir.nama_kurir', 'kurir_toko_penjual.id_kecamatan')
            ->leftJoin('kurir', 'kurir.id_kurir', '=', 'kurir_toko_penjual.id_kurir')
            ->where('kurir_toko_penjual.status', '1')
            ->where('kurir_toko_penjual.id_toko_penjual', $toko->id_toko_penjual)
            ->whereNotNull('kurir.nama_kurir')
            ->get();

        $keranjang = DB::table('transaksi_sementara')
            ->select('transaksi_sementara.id_transaksi_sementara', 'produk.nama_produk', 'transaksi_sementara.harga_produk', 'transaksi_sementara.stok_produk', 'transaksi_sementara.berat_produk', 'transaksi_sementara.diskon_produk', 'transaksi_sementara.penawaran_produk')
            ->leftJoin('produk', 'produk.id_produk', '=', 'transaksi_sementara.id_produk')
            ->where('transaksi_sementara.id_transaksi_sementara', $id_transaksi_sementara)->where('transaksi_sementara.id_user', $id)->get();

        //return $keranjang;
        if ($data != null) {
            $qx = "keyword=" . $data;
            return redirect()->route('pencarian', $qx);
        }
        return view('produk.keranjang_bayar', compact('menu_kategori', 'keranjang', 'toko', 'kurir'));
    }

    public function simpan_transaksi(Request $request)
    {
        $id =  $request->z_id_user;
        $toko = DB::table('toko_penjual')->select("nama_toko")->where('id_toko_penjual', $request->z_id_toko)->first();
        $kode_transaksi = time() . "$toko->nama_toko" . date('M-Y');
        $simpan = DB::table('transaksi')
            ->insertGetId([
                "id_user" => $id, "id_toko" => $request->z_id_toko,
                "nomor_transaksi" => $kode_transaksi, "total_bayar_barang" => $request->z_total_bayar_barang,
                "total_bayar_kurir" => $request->z_total_bayar_kurir,
                "jasa_kurir" => $request->z_jasa_kurir, "lokasi_pengiriman" => $request->z_lokasi_pengiriman, "konfirmasi" => "konfrimasi"
            ]);
        $keranjang = DB::table('transaksi_sementara')->where('id_transaksi_sementara', $request->z_id_transaksi_semsentara)->first();
        if ($keranjang) {
            if ($keranjang->penawaran_produk) {
                DB::table('transaksi_detail')->insert([
                    "id_transaksi" => $simpan,
                    "id_produk" => $keranjang->id_produk,
                    "harga_produk" => $keranjang->harga_produk,
                    "stok_produk" => $keranjang->stok_produk,
                    "berat_produk" => $keranjang->berat_produk,
                    "diskon_produk" => $keranjang->diskon_produk,
                    "penawaran_produk" => $keranjang->penawaran_produk,
                    "tanggal_penawaran" => $keranjang->tanggal_penawaran,
                    "status" => "konfrimasi",
                ]);
            } else {
                DB::table('transaksi_detail')->insert([
                    "id_transaksi" => $simpan,
                    "id_produk" => $keranjang->id_produk,
                    "harga_produk" => $keranjang->harga_produk,
                    "stok_produk" => $keranjang->stok_produk,
                    "berat_produk" => $keranjang->berat_produk,
                    "diskon_produk" => $keranjang->diskon_produk,
                    "status" => "konfrimasi",
                ]);
            }
            DB::delete('delete from transaksi_sementara where id_transaksi_sementara = ?', [$request->z_id_transaksi_semsentara]);
            return true;
        }
    }

    public function bayar_keranjang_all(Request $request, $id_toko_penjual)
    {
        $menu_kategori = DB::select("SELECT * from kategori");

        $id =  $request->session()->get('id_user');
        $data = $request->query('keyword');
        $sum = 0;

        $toko = DB::table('toko_penjual')
            ->select('id_toko_penjual', 'nama_toko')
            ->where('id_toko_penjual', $id_toko_penjual)
            ->first();

        $kurir = DB::table('kurir_toko_penjual')
            ->select('kurir.nama_kurir', 'kurir_toko_penjual.id_kecamatan')
            ->leftJoin('kurir', 'kurir.id_kurir', '=', 'kurir_toko_penjual.id_kurir')
            ->where('kurir_toko_penjual.status', '1')
            ->where('kurir_toko_penjual.id_toko_penjual', $id_toko_penjual)
            ->whereNotNull('kurir.nama_kurir')
            ->get();

        $keranjang = DB::table('transaksi_sementara')
            ->select('transaksi_sementara.id_transaksi_sementara', 'produk.nama_produk', 'transaksi_sementara.harga_produk', 'transaksi_sementara.stok_produk', 'transaksi_sementara.berat_produk', 'transaksi_sementara.diskon_produk', 'transaksi_sementara.penawaran_produk')
            ->leftJoin('produk', 'produk.id_produk', '=', 'transaksi_sementara.id_produk')
            ->leftJoin('toko_penjual', 'toko_penjual.id_toko_penjual', '=', 'produk.id_toko_penjual')
            ->where('toko_penjual.id_toko_penjual', $id_toko_penjual)
            ->where('transaksi_sementara.id_user', $id)
            ->get();

        //return $keranjang;
        if ($data != null) {
            $qx = "keyword=" . $data;
            return redirect()->route('pencarian', $qx);
        }
        return view('produk.keranjang_bayar_all', compact('menu_kategori', 'keranjang', 'toko', 'kurir'));
    }

    public function simpan_transaksi_all(Request $request)
    {
        $id =  $request->z_id_user;
        $toko = DB::table('toko_penjual')->select("nama_toko")->where('id_toko_penjual', $request->z_id_toko)->first();
        $kode_transaksi = time() . "$toko->nama_toko" . date('M-Y');

        $simpan = DB::table('transaksi')
            ->insertGetId([
                "id_user" => $id, "id_toko" => $request->z_id_toko,
                "nomor_transaksi" => $kode_transaksi, "total_bayar_barang" => $request->z_total_bayar_barang,
                "total_bayar_kurir" => $request->z_total_bayar_kurir,
                "jasa_kurir" => $request->z_jasa_kurir, "lokasi_pengiriman" => $request->z_lokasi_pengiriman, "konfirmasi" => "konfrimasi"
            ]);

        $keranjang = DB::table('transaksi_sementara')
            ->select('transaksi_sementara.*')
            ->leftJoin('produk', 'produk.id_produk', '=', 'transaksi_sementara.id_produk')
            ->leftJoin('toko_penjual', 'toko_penjual.id_toko_penjual', '=', 'produk.id_toko_penjual')
            ->where('toko_penjual.id_toko_penjual', $request->z_id_toko)
            ->where('transaksi_sementara.id_user', $id)
            ->get();

        for ($a = 0; $a < count($keranjang); $a++) {
            if ($keranjang[$a]->penawaran_produk) {
                DB::table('transaksi_detail')->insert([
                    "id_transaksi" => $simpan,
                    "id_produk" => $keranjang[$a]->id_produk,
                    "harga_produk" => $keranjang[$a]->harga_produk,
                    "stok_produk" => $keranjang[$a]->stok_produk,
                    "berat_produk" => $keranjang[$a]->berat_produk,
                    "diskon_produk" => $keranjang[$a]->diskon_produk,
                    "penawaran_produk" => $keranjang[$a]->penawaran_produk,
                    "tanggal_penawaran" => $keranjang[$a]->tanggal_penawaran,
                    "status" => "konfrimasi",
                ]);
            } else {
                DB::table('transaksi_detail')->insert([
                    "id_transaksi" => $simpan,
                    "id_produk" => $keranjang[$a]->id_produk,
                    "harga_produk" => $keranjang[$a]->harga_produk,
                    "stok_produk" => $keranjang[$a]->stok_produk,
                    "berat_produk" => $keranjang[$a]->berat_produk,
                    "diskon_produk" => $keranjang[$a]->diskon_produk,
                    "status" => "konfrimasi",
                ]);
            }
            DB::delete('delete from transaksi_sementara where id_transaksi_sementara = ? ', [$keranjang[$a]->id_transaksi_sementara]);
        }
        return true;
    }
}
