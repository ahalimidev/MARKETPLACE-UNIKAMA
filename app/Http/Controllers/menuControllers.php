<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class menuControllers extends Controller
{
    public function kategori_show($nama, $id, Request $request)
    {
        $menu_kategori = DB::select("SELECT * from kategori");

        $kategori_sub = DB::select("SELECT * from sub_kategori where id_kategori ='$id'");

        $filter = $request->query('filter');
        $harga_awal = $request->query('harga_awal');
        $harga_akhir = $request->query('harga_akhir');
        $data = $request->query('keyword');

        if($data != null){
            $qx = "keyword=".$data;
            return redirect()->route('pencarian',$qx);
        }

        if ($filter == "terlaris") {
            $paginator = DB::table('produk')
                ->leftJoin('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
                ->leftJoin('sub_kategori', 'sub_kategori.id_sub_kategori', '=', 'produk.id_sub_kategori')
                ->leftJoin('toko_penjual', 'toko_penjual.id_toko_penjual', '=', 'produk.id_toko_penjual')
                ->select(
                    'produk.id_produk',
                    'produk.nama_produk',
                    'toko_penjual.nama_toko',
                    'produk.harga_produk',
                    'produk.stok_produk',
                    'produk.diskon_produk',
                    'produk.foto_produk',
                    'kategori.nama_kategori',
                    'sub_kategori.nama_sub_kategori',
                    DB::raw("(SELECT AVG(r.rating) FROM transaksi_detail r WHERE r.id_produk = produk.id_produk) AS rating "),
                    DB::raw("(SELECT COUNT(q.rating) FROM transaksi_detail q WHERE q.id_produk = produk.id_produk) AS total ")
                )
                ->where('produk.id_kategori',$id)
                ->orderBy('rating', 'desc')->paginate(8);
        } else if ($filter == "terbaru") {

            $paginator = DB::table('produk')
                ->leftJoin('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
                ->leftJoin('sub_kategori', 'sub_kategori.id_sub_kategori', '=', 'produk.id_sub_kategori')
                ->leftJoin('toko_penjual', 'toko_penjual.id_toko_penjual', '=', 'produk.id_toko_penjual')
                ->select(
                    'produk.id_produk',
                    'produk.nama_produk',
                    'toko_penjual.nama_toko',
                    'produk.harga_produk',
                    'produk.stok_produk',
                    'produk.diskon_produk',
                    'produk.foto_produk',
                    'kategori.nama_kategori',
                    'sub_kategori.nama_sub_kategori',
                    DB::raw("(SELECT AVG(r.rating) FROM transaksi_detail r WHERE r.id_produk = produk.id_produk) AS rating "),
                    DB::raw("(SELECT COUNT(q.rating) FROM transaksi_detail q WHERE q.id_produk = produk.id_produk) AS total ")
                )
                ->where('produk.id_kategori',$id)
                ->orderBy('produk.id_produk', 'desc')->paginate(8);

        }else if($harga_akhir != null && $harga_akhir != null){
            $paginator = DB::table('produk')
            ->leftJoin('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
            ->leftJoin('sub_kategori', 'sub_kategori.id_sub_kategori', '=', 'produk.id_sub_kategori')
            ->leftJoin('toko_penjual', 'toko_penjual.id_toko_penjual', '=', 'produk.id_toko_penjual')
            ->select(
                'produk.id_produk',
                'produk.nama_produk',
                'toko_penjual.nama_toko',
                'produk.harga_produk',
                'produk.stok_produk',
                'produk.diskon_produk',
                'produk.foto_produk',
                'kategori.nama_kategori',
                'sub_kategori.nama_sub_kategori',
                DB::raw("(SELECT AVG(r.rating) FROM transaksi_detail r WHERE r.id_produk = produk.id_produk) AS rating "),
                DB::raw("(SELECT COUNT(q.rating) FROM transaksi_detail q WHERE q.id_produk = produk.id_produk) AS total ")
            )
            ->where('produk.id_kategori',$id)
            ->whereBetween('produk.harga_produk',[$harga_awal,$harga_akhir])
            ->orderBy('produk.harga_produk', 'desc')
            ->paginate(8);

        } else {
            $paginator = DB::table('produk')
            ->leftJoin('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
            ->leftJoin('sub_kategori', 'sub_kategori.id_sub_kategori', '=', 'produk.id_sub_kategori')
            ->leftJoin('toko_penjual', 'toko_penjual.id_toko_penjual', '=', 'produk.id_toko_penjual')
            ->select(
                'produk.id_produk',
                'produk.nama_produk',
                'toko_penjual.nama_toko',
                'produk.harga_produk',
                'produk.stok_produk',
                'produk.diskon_produk',
                'produk.foto_produk',
                'kategori.nama_kategori',
                'sub_kategori.nama_sub_kategori',
                DB::raw("(SELECT AVG(r.rating) FROM transaksi_detail r WHERE r.id_produk = produk.id_produk) AS rating "),
                DB::raw("(SELECT COUNT(q.rating) FROM transaksi_detail q WHERE q.id_produk = produk.id_produk) AS total ")
            )
            ->where('produk.id_kategori',$id)
            ->orderBy('rating', 'desc')->paginate(8);

        }

        return view('produk.kategori', compact('kategori_sub', 'paginator', 'nama','menu_kategori'));
    }

    public function kategori_sub_show($kategori, $nama, $id,Request $request)
    {
        $menu_kategori = DB::select("SELECT * from kategori");

        $filter = $request->query('filter');
        $harga_awal = $request->query('harga_awal');
        $harga_akhir = $request->query('harga_akhir');

        $data = $request->query('keyword');

        if($data != null){
            $qx = "keyword=".$data;
            return redirect()->route('pencarian',$qx);
        }
        if ($filter == "terlaris") {
            $paginator = DB::table('produk')
                ->leftJoin('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
                ->leftJoin('sub_kategori', 'sub_kategori.id_sub_kategori', '=', 'produk.id_sub_kategori')
                ->leftJoin('toko_penjual', 'toko_penjual.id_toko_penjual', '=', 'produk.id_toko_penjual')
                ->select(
                    'produk.id_produk',
                    'produk.nama_produk',
                    'toko_penjual.nama_toko',
                    'produk.harga_produk',
                    'produk.stok_produk',
                    'produk.diskon_produk',
                    'produk.foto_produk',
                    'kategori.nama_kategori',
                    'sub_kategori.nama_sub_kategori',
                    DB::raw("(SELECT AVG(r.rating) FROM transaksi_detail r WHERE r.id_produk = produk.id_produk) AS rating "),
                    DB::raw("(SELECT COUNT(q.rating) FROM transaksi_detail q WHERE q.id_produk = produk.id_produk) AS total ")
                )
                ->where('sub_kategori.id_sub_kategori',$id)
                ->orderBy('rating', 'desc')->paginate(8);
        } else if ($filter == "terbaru") {

            $paginator = DB::table('produk')
                ->leftJoin('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
                ->leftJoin('sub_kategori', 'sub_kategori.id_sub_kategori', '=', 'produk.id_sub_kategori')
                ->leftJoin('toko_penjual', 'toko_penjual.id_toko_penjual', '=', 'produk.id_toko_penjual')
                ->select(
                    'produk.id_produk',
                    'produk.nama_produk',
                    'toko_penjual.nama_toko',
                    'produk.harga_produk',
                    'produk.stok_produk',
                    'produk.diskon_produk',
                    'produk.foto_produk',
                    'kategori.nama_kategori',
                    'sub_kategori.nama_sub_kategori',
                    DB::raw("(SELECT AVG(r.rating) FROM transaksi_detail r WHERE r.id_produk = produk.id_produk) AS rating "),
                    DB::raw("(SELECT COUNT(q.rating) FROM transaksi_detail q WHERE q.id_produk = produk.id_produk) AS total ")
                )
                ->where('sub_kategori.id_sub_kategori',$id)
                ->orderBy('produk.id_produk', 'desc')->paginate(8);

        }else if($harga_akhir != null && $harga_akhir != null){
            $paginator = DB::table('produk')
            ->leftJoin('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
            ->leftJoin('sub_kategori', 'sub_kategori.id_sub_kategori', '=', 'produk.id_sub_kategori')
            ->leftJoin('toko_penjual', 'toko_penjual.id_toko_penjual', '=', 'produk.id_toko_penjual')
            ->select(
                'produk.id_produk',
                'produk.nama_produk',
                'toko_penjual.nama_toko',
                'produk.harga_produk',
                'produk.stok_produk',
                'produk.diskon_produk',
                'produk.foto_produk',
                'kategori.nama_kategori',
                'sub_kategori.nama_sub_kategori',
                DB::raw("(SELECT AVG(r.rating) FROM transaksi_detail r WHERE r.id_produk = produk.id_produk) AS rating "),
                DB::raw("(SELECT COUNT(q.rating) FROM transaksi_detail q WHERE q.id_produk = produk.id_produk) AS total ")
            )
            ->where('sub_kategori.id_sub_kategori',$id)
            ->whereBetween('produk.harga_produk',[$harga_awal,$harga_akhir])
            ->orderBy('produk.harga_produk', 'desc')
            ->paginate(8);

        } else {
            $paginator = DB::table('produk')
            ->leftJoin('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
            ->leftJoin('sub_kategori', 'sub_kategori.id_sub_kategori', '=', 'produk.id_sub_kategori')
            ->leftJoin('toko_penjual', 'toko_penjual.id_toko_penjual', '=', 'produk.id_toko_penjual')
            ->select(
                'produk.id_produk',
                'produk.nama_produk',
                'toko_penjual.nama_toko',
                'produk.harga_produk',
                'produk.stok_produk',
                'produk.diskon_produk',
                'produk.foto_produk',
                'kategori.nama_kategori',
                'sub_kategori.nama_sub_kategori',
                DB::raw("(SELECT AVG(r.rating) FROM transaksi_detail r WHERE r.id_produk = produk.id_produk) AS rating "),
                DB::raw("(SELECT COUNT(q.rating) FROM transaksi_detail q WHERE q.id_produk = produk.id_produk) AS total ")
            )
            ->where('sub_kategori.id_sub_kategori',$id)
            ->orderBy('rating', 'desc')->paginate(8);

        }
        return view('produk.sub_kategori', compact('kategori', 'nama', 'id','paginator','menu_kategori'));
    }
    public function Detail_Produk(Request $request,$nama,$id)
    {
        $menu_kategori = DB::select("SELECT * from kategori");

        $data = $request->query('keyword');

        if($data != null){
            $qx = "keyword=".$data;
            return redirect()->route('pencarian',$qx);
        }
        $detail_produk = DB::table('produk')
        ->leftJoin('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
        ->leftJoin('sub_kategori', 'sub_kategori.id_sub_kategori', '=', 'produk.id_sub_kategori')
        ->leftJoin('toko_penjual', 'toko_penjual.id_toko_penjual', '=', 'produk.id_toko_penjual')
        ->select(
            'produk.id_produk',
            'produk.nama_produk',
            'toko_penjual.nama_toko',
            'produk.keterangan_produk',
            'produk.id_kategori',
            'produk.harga_produk',
            'produk.stok_produk',
            'produk.diskon_produk',
            'produk.foto_produk',
            'kategori.nama_kategori',
            'sub_kategori.nama_sub_kategori',
            DB::raw("(SELECT AVG(r.rating) FROM transaksi_detail r WHERE r.id_produk = produk.id_produk) AS rating "),
            DB::raw("(SELECT COUNT(q.rating) FROM transaksi_detail q WHERE q.id_produk = produk.id_produk) AS total ")
        )->where('id_produk',$id)->first();


        $review = DB::table('transaksi_detail')
        ->select('transaksi_detail.rating','transaksi_detail.komentar','user.nama_user')
        ->leftJoin('transaksi','transaksi.id_transaksi','=','transaksi_detail.id_transaksi')
        ->leftJoin('user','user.id_user','=','transaksi.id_user')
        ->where('id_produk',$id)->get();


        $paginator = DB::table('produk')
        ->leftJoin('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
        ->leftJoin('sub_kategori', 'sub_kategori.id_sub_kategori', '=', 'produk.id_sub_kategori')
        ->leftJoin('toko_penjual', 'toko_penjual.id_toko_penjual', '=', 'produk.id_toko_penjual')
        ->select(
            'produk.id_produk',
            'produk.nama_produk',
            'toko_penjual.nama_toko',
            'produk.harga_produk',
            'produk.stok_produk',
            'produk.diskon_produk',
            'produk.foto_produk',
            'kategori.nama_kategori',
            'sub_kategori.nama_sub_kategori',
            DB::raw("(SELECT AVG(r.rating) FROM transaksi_detail r WHERE r.id_produk = produk.id_produk) AS rating "),
            DB::raw("(SELECT COUNT(q.rating) FROM transaksi_detail q WHERE q.id_produk = produk.id_produk) AS total ")
        )
        ->where('produk.id_kategori',$detail_produk->id_kategori)
        ->orderBy('rating', 'desc')->paginate(8);


        $toko = DB::table('toko_penjual')
        ->select('toko_penjual.*','provinces.name_provinces','regencies.name_regencies','districts.name_districts','villages.name_villages')
        ->leftJoin('produk','produk.id_toko_penjual','=','toko_penjual.id_toko_penjual')
        ->leftJoin('provinces','provinces.id_provinces','=','toko_penjual.id_provinsi')
        ->leftJoin('regencies','regencies.id_regencies','=','toko_penjual.id_kabupaten')
        ->leftJoin('districts','districts.id_districts','=','toko_penjual.id_kecamatan')
        ->leftJoin('villages','villages.id_villages','=','toko_penjual.id_desa')
        ->where('produk.id_produk',$id)->first();
        return view('produk.detail',compact('nama','id','detail_produk','review','toko','paginator','menu_kategori'));
    }
}
