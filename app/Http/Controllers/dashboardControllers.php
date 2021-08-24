<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboardControllers extends Controller
{
    public function index(Request $request){
        $menu_kategori = DB::select("SELECT * from kategori");
        $data = $request->query('keyword');

        if($data != null){
            $qx = "keyword=".$data;
            return redirect()->route('pencarian',$qx);
        }


        $telaris = DB::select("SELECT produk.id_produk,produk.nama_produk,toko_penjual.nama_toko,produk.harga_produk,produk.stok_produk,produk.diskon_produk,produk.foto_produk,kategori.nama_kategori,sub_kategori.nama_sub_kategori,AVG(transaksi_detail.rating) as rating,COUNT(transaksi_detail.rating) as total FROM produk
        LEFT OUTER JOIN kategori on kategori.id_kategori = produk.id_kategori
        LEFT OUTER JOIN sub_kategori on sub_kategori.id_sub_kategori = produk.id_sub_kategori
        LEFT OUTER JOIN transaksi_detail on transaksi_detail.id_produk = produk.id_produk
        LEFT OUTER JOIN toko_penjual on produk.id_toko_penjual = toko_penjual.id_toko_penjual
       	where transaksi_detail.rating IS NOT NULL
        GROUP BY produk.nama_produk ORDER BY transaksi_detail.rating DESC limit 10");

        $terbaru = DB::select("SELECT produk.id_produk,produk.nama_produk,produk.harga_produk,produk.stok_produk,produk.diskon_produk,produk.foto_produk,kategori.nama_kategori,sub_kategori.nama_sub_kategori,(SELECT AVG(r.rating) FROM transaksi_detail r WHERE r.id_produk = produk.id_produk) AS rating, (SELECT COUNT(q.rating) FROM transaksi_detail q WHERE q.id_produk = produk.id_produk) AS total,toko_penjual.nama_toko FROM produk
        LEFT OUTER JOIN kategori on kategori.id_kategori = produk.id_kategori
        LEFT OUTER JOIN sub_kategori on sub_kategori.id_sub_kategori = produk.id_sub_kategori
        LEFT OUTER JOIN toko_penjual on produk.id_toko_penjual = toko_penjual.id_toko_penjual

        ORDER BY produk.id_produk  DESC limit 10");
        return view('dashboard',compact('menu_kategori','telaris','terbaru'));
    }
    public function pencarian_produk (Request $request){
        $menu_kategori = DB::select("SELECT * from kategori");

        $data = $request->query('keyword');
        $filter = $request->query('filter');
        $harga_awal = $request->query('harga_awal');
        $harga_akhir = $request->query('harga_akhir');
        if ($filter == "terlaris" && $data != null) {
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
                ->where("produk.nama_produk", "like", "%$data%")
                ->orderBy('rating', 'desc')->paginate(8);
        } else if ($filter == "terbaru" && $data != null) {
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
                ->where("produk.nama_produk", "like", "%$data%")
                ->orderBy('produk.id_produk', 'desc')->paginate(8);

        }else if($harga_akhir != null && $harga_akhir != null && $data != null){
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
            ->where("produk.nama_produk", "like", "%$data%")
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
            ->where("produk.nama_produk", "like", "%$data%")
            ->orderBy('rating', 'desc')->paginate(8);

        }

        return view('pencarian',compact('data','paginator','menu_kategori'));
    }
}
