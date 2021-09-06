<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Exception;
class transaksiControllers extends Controller
{

    protected $client, $token;

    public function __construct()
    {
        $this->client = new Client();
        $this->token = "0f5bc4f275fbc61ad918e465ed73f1f9";
    }
    public function pembayaran_tampil ($id_transaksi, Request $request){
        $id =  $request->session()->get('id_user');
        $menu_kategori = DB::select("SELECT * from kategori");
        $data = $request->query('keyword');

        $transaksi = DB::table('transaksi')
        ->select("transaksi.*","toko_penjual.nomor_hp_toko")
        ->leftJoin('toko_penjual','transaksi.id_toko','=','toko_penjual.id_toko_penjual')
        ->where('id_transaksi',$id_transaksi)
        ->where('id_user',$id)->first();

        $transaksi_detail = DB::table('transaksi_detail')
        ->select("transaksi_detail.*","toko_penjual.nama_toko","produk.foto_produk","produk.nama_produk")
        ->leftJoin('transaksi','transaksi.id_transaksi','=','transaksi_detail.id_transaksi')
        ->leftJoin('toko_penjual','transaksi.id_toko','=','toko_penjual.id_toko_penjual')
        ->leftJoin('produk','produk.id_produk','=','transaksi_detail.id_produk')
        ->where('transaksi_detail.id_transaksi',$id_transaksi)
        ->where('transaksi.id_user',$id)->get();

        if ($data != null) {
            $qx = "keyword=" . $data;
            return redirect()->route('pencarian', $qx);
        }
        return view('transaksi.pembayaran', compact('menu_kategori','transaksi','transaksi_detail'));
    }

    public function pengriman_tampil ($id_transaksi, Request $request){
        $id =  $request->session()->get('id_user');
        $menu_kategori = DB::select("SELECT * from kategori");
        $data = $request->query('keyword');

        $transaksi = DB::table('transaksi')
        ->select("transaksi.*","toko_penjual.nomor_hp_toko")
        ->leftJoin('toko_penjual','transaksi.id_toko','=','toko_penjual.id_toko_penjual')
        ->where('id_transaksi',$id_transaksi)
        ->where('id_user',$id)->first();

        $transaksi_detail = DB::table('transaksi_detail')
        ->select("transaksi_detail.*","toko_penjual.nama_toko","produk.foto_produk","produk.nama_produk")
        ->leftJoin('transaksi','transaksi.id_transaksi','=','transaksi_detail.id_transaksi')
        ->leftJoin('toko_penjual','transaksi.id_toko','=','toko_penjual.id_toko_penjual')
        ->leftJoin('produk','produk.id_produk','=','transaksi_detail.id_produk')
        ->where('transaksi_detail.id_transaksi',$id_transaksi)
        ->where('transaksi.id_user',$id)->get();

        if ($data != null) {
            $qx = "keyword=" . $data;
            return redirect()->route('pencarian', $qx);
        }
        return view('transaksi.pengiriman', compact('menu_kategori','transaksi','transaksi_detail'));
    }

    public function tracking ($nomor_resi, Request $request){
        $menu_kategori = DB::select("SELECT * from kategori");
        $keyword = $request->query('keyword');
        $sql = DB::table('transaksi')->where('nomor_resi',$nomor_resi)->first();
        if($sql){
            $pieces = explode("-", $sql->jasa_kurir);
            $resi = $nomor_resi;
            $kurir = $pieces[1];
        }

        try{
            $request = $this->client->post('https://pro.rajaongkir.com/api/waybill', [
                'form_params' => [
                    'waybill' => $resi,
                    'courier' => $kurir
                ],
                'headers' => [
                    'key' => $this->token,
                ]
            ])->getBody()->getContents();

            $data['rajaongkir'] = json_decode($request, false);

        }catch(RequestException $re){
            $data['rajaongkir'] = json_decode("", false);
        }catch(Exception $e){
            $data['rajaongkir'] =json_decode("", false);
        }

        if ($keyword != null) {
            $qx = "keyword=" . $keyword;
            return redirect()->route('pencarian', $qx);
        }
        return view('transaksi.tracking', compact('menu_kategori','data'));
    }

    public function terima_barang(Request $request)
    {
        $datatanggal = date('Y-m-d h:m:s');

        return  DB::update('update transaksi set konfirmasi = ?, tanggal_terima = ? where id_transaksi = ?', ["terima", $datatanggal, $request->id_transaksi]);
    }

    public function terima_tampil ($id_transaksi, Request $request){
        $id =  $request->session()->get('id_user');
        $menu_kategori = DB::select("SELECT * from kategori");
        $data = $request->query('keyword');

        $transaksi = DB::table('transaksi')
        ->select("transaksi.*","toko_penjual.nomor_hp_toko")
        ->leftJoin('toko_penjual','transaksi.id_toko','=','toko_penjual.id_toko_penjual')
        ->where('id_transaksi',$id_transaksi)
        ->where('id_user',$id)->first();

        $transaksi_detail = DB::table('transaksi_detail')
        ->select("transaksi_detail.*","toko_penjual.nama_toko","produk.foto_produk","produk.nama_produk")
        ->leftJoin('transaksi','transaksi.id_transaksi','=','transaksi_detail.id_transaksi')
        ->leftJoin('toko_penjual','transaksi.id_toko','=','toko_penjual.id_toko_penjual')
        ->leftJoin('produk','produk.id_produk','=','transaksi_detail.id_produk')
        ->where('transaksi_detail.id_transaksi',$id_transaksi)
        ->where('transaksi.id_user',$id)->get();

        if ($data != null) {
            $qx = "keyword=" . $data;
            return redirect()->route('pencarian', $qx);
        }
        return view('transaksi.terima', compact('menu_kategori','transaksi','transaksi_detail'));
    }

    public function beri_rating ($id_transaksi_detail, Request $request){
        $id =  $request->session()->get('id_user');
        $menu_kategori = DB::select("SELECT * from kategori");
        $data = $request->query('keyword');
        $transaksi_detail = DB::table('transaksi_detail')
        ->select("transaksi_detail.*","toko_penjual.nama_toko","produk.foto_produk","produk.nama_produk")
        ->leftJoin('produk','produk.id_produk','=','transaksi_detail.id_produk')
        ->leftJoin('toko_penjual','produk.id_toko_penjual','=','toko_penjual.id_toko_penjual')
        ->where('transaksi_detail.id_transaksi_detail',$id_transaksi_detail)->first();

        return view('transaksi.rating', compact('menu_kategori','transaksi_detail'));
    }

    public function komentar_dan_rating(Request $request,$id_transaksi_detail)
    {
        DB::update('update transaksi_detail set rating = ? , komentar = ? where id_transaksi_detail = ?', [$request->rating,$request->komentar,$id_transaksi_detail]);
         return redirect()->route('profil');
    }

    public function batal(Request $request,$id_transaksi){
        $id =  $request->session()->get('id_user');
        $menu_kategori = DB::select("SELECT * from kategori");
        $data = $request->query('keyword');

        $transaksi = DB::table('transaksi')
        ->select("transaksi.*","toko_penjual.nomor_hp_toko")
        ->leftJoin('toko_penjual','transaksi.id_toko','=','toko_penjual.id_toko_penjual')
        ->where('id_transaksi',$id_transaksi)
        ->where('id_user',$id)->first();

        $transaksi_detail = DB::table('transaksi_detail')
        ->select("transaksi_detail.*","toko_penjual.nama_toko","produk.foto_produk","produk.nama_produk")
        ->leftJoin('transaksi','transaksi.id_transaksi','=','transaksi_detail.id_transaksi')
        ->leftJoin('toko_penjual','transaksi.id_toko','=','toko_penjual.id_toko_penjual')
        ->leftJoin('produk','produk.id_produk','=','transaksi_detail.id_produk')
        ->where('transaksi_detail.id_transaksi',$id_transaksi)
        ->where('transaksi.id_user',$id)->get();

        if ($data != null) {
            $qx = "keyword=" . $data;
            return redirect()->route('pencarian', $qx);
        }
        return view('transaksi.batal', compact('menu_kategori','transaksi','transaksi_detail'));
    }
}
