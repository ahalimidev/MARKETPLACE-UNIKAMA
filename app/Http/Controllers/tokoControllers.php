<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class tokoControllers extends Controller
{
    public function index(Request $request ,$id){
        $menu_kategori = DB::select("SELECT * from kategori");
        $toko = DB::table('toko_penjual')
        ->select('toko_penjual.*','provinces.name_provinces','regencies.name_regencies','districts.name_districts','villages.name_villages')
        ->leftJoin('produk','produk.id_toko_penjual','=','toko_penjual.id_toko_penjual')
        ->leftJoin('provinces','provinces.id_provinces','=','toko_penjual.id_provinsi')
        ->leftJoin('regencies','regencies.id_regencies','=','toko_penjual.id_kabupaten')
        ->leftJoin('districts','districts.id_districts','=','toko_penjual.id_kecamatan')
        ->leftJoin('villages','villages.id_villages','=','toko_penjual.id_desa')
        ->where('toko_penjual.id_toko_penjual',$id)->first();

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
        ->where('toko_penjual.id_toko_penjual',$id)
        ->orderBy('produk.id_produk', 'desc')->paginate(8);


        $data = $request->query('keyword');

        if ($data != null) {
            $qx = "keyword=" . $data;
            return redirect()->route('pencarian', $qx);
        }
        return view('toko.list', compact('menu_kategori','toko','paginator'));
    }
}
