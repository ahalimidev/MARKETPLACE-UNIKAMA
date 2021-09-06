<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class authControllers extends Controller
{
    public function login(Request $request)
    {
        $menu_kategori = DB::select("SELECT * from kategori");
        $data = $request->query('keyword');

        if ($data != null) {
            $qx = "keyword=" . $data;
            return redirect()->route('pencarian', $qx);
        }
        return view('auth.login', compact('menu_kategori'));
    }
    public function login_akses(Request $request)
    {
        $username = $request->input('username');
        $password = md5($request->input('password'));
        $login = collect(DB::select("select * from user where username = ? and password = ?", [$username, $password]))->first();
        if ($login != null) {

            Session::flash('success', 'Selamat Datang');
            $request->session()->put('login_user', true);
            $request->session()->put('id_user', $login->id_user);
            return Redirect()->route('index');
        } else {
            $request->session()->flash('error', 'Username atau password salah');
            return Redirect()->route('login');
        }
    }
    public function daftar(Request $request)
    {
        $menu_kategori = DB::select("SELECT * from kategori");
        $provinces = DB::select('select * from provinces');

        $data = $request->query('keyword');

        if ($data != null) {
            $qx = "keyword=" . $data;
            return redirect()->route('pencarian', $qx);
        }
        return view('auth.daftar', compact('menu_kategori', 'provinces'));
    }

    public function daftar_akses(Request $request)
    {
        $request->validate([
            'nama_user' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'id_provinsi' => 'required',
            'id_kabupaten' => 'required',
            'id_kecamatan' => 'required',
            'id_desa' => 'required',
            'username' => 'required',
            'password' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();
        $input['password'] = md5($request->input('password'));

        if (collect(DB::select("select * from user where username = ?", [$request->username]))->first()) {
           $request->session()->flash('error', 'Username sudah ada');
            return redirect()->route('daftar');

        }

        if (collect(DB::select("select * from user where email = ?", [$request->email]))->first()) {
            $request->session()->flash('error', 'email sudah ada');
            return redirect()->route('daftar');
        }

        if (collect(DB::select("select * from user where telepon = ?", [$request->telepon]))->first()) {
            $request->session()->flash('error', 'telepon sudah ada');
            return redirect()->route('daftar');
        }

        if ($image = $request->file('foto')) {
            $rules = array(
                'foto' => 'mimes:jpeg,jpg,png,gif|required|max:10000' // max 10000kb
            );
            $validator = Validator::make($request->file('foto'), $rules);
            if ($validator->fails()) {
                $request->session()->flash('error', $validator->errors()->getMessages());
                return redirect()->route('daftar');
            } else {
                $destinationPath = 'image/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['foto'] = "$profileImage";
            };
        }
        $user =  DB::table('user')->insertGetId([
            'nama_user' => $input['nama_user'],
            'jenis_kelamin' => $input['jenis_kelamin'],
            'email' => $input['email'],
            'telepon' => $input['telepon'],
            'alamat' => $input['alamat'],
            'id_provinsi' => $input['id_provinsi'],
            'id_kabupaten' => $input['id_kabupaten'],
            'id_kecamatan' => $input['id_kecamatan'],
            'id_desa' => $input['id_desa'],
            'username' => $input['username'],
            'password' => $input['password'],
        ],'id_user');
        Session::flash('success', 'Selamat Datang');
        $request->session()->put('login_user', true);
        $request->session()->put('id_user', $user);
        return redirect()->route('index')->with('success', 'User Berhasil Ditambahkan');
    }

    public function lupa_password(Request $request)
    {
        $menu_kategori = DB::select("SELECT * from kategori");
        $data = $request->query('keyword');

        if ($data != null) {
            $qx = "keyword=" . $data;
            return redirect()->route('pencarian', $qx);
        }
        return view('auth.lupa_password', compact('menu_kategori'));
    }

    public function profil(Request $request)
    {
        $id =  $request->session()->get('id_user');

        $konfrimasi = DB::table('transaksi')
        ->select('transaksi.id_transaksi','transaksi.nomor_transaksi','transaksi.nomor_resi','transaksi.total_bayar_barang',
        'transaksi.total_bayar_kurir','transaksi.jasa_kurir',
        'transaksi.lokasi_pengiriman','toko_penjual.nomor_hp_toko',DB::raw('count(transaksi_detail.id_transaksi) as total'),'transaksi.catatan_batal')
        ->leftJoin('toko_penjual','toko_penjual.id_toko_penjual','=','transaksi.id_toko')
        ->leftJoin('transaksi_detail','transaksi_detail.id_transaksi','=','transaksi.id_transaksi')
        ->where('transaksi.konfirmasi','konfrimasi')
        ->where('transaksi.id_user',$id)
        ->orderByDesc('transaksi.id_transaksi')
        ->paginate(5);

        $selesai = DB::table('transaksi')
        ->select('transaksi.id_transaksi','transaksi.nomor_transaksi','transaksi.nomor_resi','transaksi.total_bayar_barang',
        'transaksi.total_bayar_kurir','transaksi.jasa_kurir',
        'transaksi.lokasi_pengiriman','toko_penjual.nomor_hp_toko',DB::raw('count(transaksi_detail.id_transaksi) as total'),'transaksi.catatan_batal')
        ->leftJoin('toko_penjual','toko_penjual.id_toko_penjual','=','transaksi.id_toko')
        ->leftJoin('transaksi_detail','transaksi_detail.id_transaksi','=','transaksi.id_transaksi')
        ->where('transaksi.konfirmasi','selesai')
        ->where('transaksi.id_user',$id)
        ->orderByDesc('transaksi.id_transaksi')
        ->paginate(5);

        $terima = DB::table('transaksi')
        ->select('transaksi.id_transaksi','transaksi.nomor_transaksi','transaksi.nomor_resi','transaksi.total_bayar_barang',
        'transaksi.total_bayar_kurir','transaksi.jasa_kurir',
        'transaksi.lokasi_pengiriman','toko_penjual.nomor_hp_toko',DB::raw('count(transaksi_detail.id_transaksi) as total'),'transaksi.catatan_batal')
        ->leftJoin('toko_penjual','toko_penjual.id_toko_penjual','=','transaksi.id_toko')
        ->leftJoin('transaksi_detail','transaksi_detail.id_transaksi','=','transaksi.id_transaksi')
        ->where('transaksi.konfirmasi','terima')
        ->where('transaksi.id_user',$id)
        ->orderByDesc('transaksi.id_transaksi')
        ->paginate(5);

        $batal = DB::table('transaksi')
        ->select('transaksi.id_transaksi','transaksi.nomor_transaksi','transaksi.nomor_resi','transaksi.total_bayar_barang',
        'transaksi.total_bayar_kurir','transaksi.jasa_kurir',
        'transaksi.lokasi_pengiriman','toko_penjual.nomor_hp_toko',DB::raw('count(transaksi_detail.id_transaksi) as total'),'transaksi.catatan_batal')
        ->leftJoin('toko_penjual','toko_penjual.id_toko_penjual','=','transaksi.id_toko')
        ->leftJoin('transaksi_detail','transaksi_detail.id_transaksi','=','transaksi.id_transaksi')
        ->where('transaksi.konfirmasi','batal')
        ->where('transaksi.id_user',$id)
        ->orderByDesc('transaksi.id_transaksi')
        ->paginate(5);


        $menu_kategori = DB::select("SELECT * from kategori");
        $profil = collect(DB::select("SELECT user.*,provinces.name_provinces,regencies.name_regencies,districts.name_districts,villages.name_villages FROM user
        LEFT OUTER JOIN provinces on provinces.id_provinces = user.id_provinsi
        LEFT OUTER JOIN regencies on regencies.id_regencies = user.id_kabupaten
        LEFT OUTER JOIN districts on districts.id_districts = user.id_kecamatan
        LEFT OUTER JOIN villages on villages.id_villages = user.id_desa
        WHERE user.id_user = '$id' "))->first();
        $data = $request->query('keyword');

        if ($data != null) {
            $qx = "keyword=" . $data;
            return redirect()->route('pencarian', $qx);
        }
        return view('auth.profil', compact('menu_kategori','profil','konfrimasi', 'selesai', 'terima', 'batal'));
    }

    public function profil_detail(Request $request)
    {
        $id =  $request->session()->get('id_user');

        $menu_kategori = DB::select("SELECT * from kategori");
        $profil = collect(DB::select("SELECT user.*,provinces.name_provinces,regencies.name_regencies,districts.name_districts,villages.name_villages FROM user
        LEFT OUTER JOIN provinces on provinces.id_provinces = user.id_provinsi
        LEFT OUTER JOIN regencies on regencies.id_regencies = user.id_kabupaten
        LEFT OUTER JOIN districts on districts.id_districts = user.id_kecamatan
        LEFT OUTER JOIN villages on villages.id_villages = user.id_desa
        WHERE user.id_user = '$id' "))->first();
        $provinces = DB::select('select * from provinces');
        $regencies = DB::select('select * from regencies where id_provinces = ?',[$profil->id_provinsi]);
        $districts = DB::select('select * from districts where id_regencies = ?',[$profil->id_kabupaten]);
        $villages = DB::select('select * from villages where id_districts = ?',[$profil->id_kecamatan]);
        $data = $request->query('keyword');

        if ($data != null) {
            $qx = "keyword=" . $data;
            return redirect()->route('pencarian', $qx);
        }
        return view('auth.profil_detail', compact('menu_kategori','profil','provinces','regencies','districts','villages'));
    }

    public function profil_biodata(Request $request)
    {
        $id =  $request->session()->get('id_user');

        $request->validate([
            'nama_user' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'id_provinsi' => 'required',
            'id_kabupaten' => 'required',
            'id_kecamatan' => 'required',
            'id_desa' => 'required',
        ]);

        $input = $request->all();

        if (collect(DB::select("select * from user where email = ?", [$request->email]))->first()) {
            $request->session()->flash('error', 'email sudah ada');
            return redirect()->route('daftar');
        }

        if (collect(DB::select("select * from user where telepon = ?", [$request->telepon]))->first()) {
            $request->session()->flash('error', 'telepon sudah ada');
            return redirect()->route('daftar');
        }
        DB::table('user')->where('id_user',$id)->update([
            'nama_user' => $input['nama_user'],
            'jenis_kelamin' => $input['jenis_kelamin'],
            'email' => $input['email'],
            'telepon' => $input['telepon'],
            'alamat' => $input['alamat'],
            'id_provinsi' => $input['id_provinsi'],
            'id_kabupaten' => $input['id_kabupaten'],
            'id_kecamatan' => $input['id_kecamatan'],
            'id_desa' => $input['id_desa'],
        ]);


        return redirect()->route('profil')->with('success', 'User Berhasil Ditambahkan');
    }

    public function profil_password(Request $request)
    {
        $id =  $request->session()->get('id_user');

        $request->validate([
            'password' => 'required',
            'password_ulang' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = md5($request->input('password'));

        DB::table('user')->where('id_user',$id)->update([
            'password' => $input['password'],
        ]);

        return redirect()->route('profil')->with('success', 'User Berhasil Ditambahkan');
    }

    public function profil_upload(Request $request)
    {
        $id =  $request->session()->get('id_user');
        $user = collect(DB::select('select * from user where id_user = ?', [$id]))->first();
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $input = $request->all();
        if ($image = $request->file('foto')) {
            $image_path = public_path("image/".$user->foto);

            if (file_exists( $image_path)) {
                @unlink($image_path);
            }

            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['foto'] = "$profileImage";
        }

        DB::table('user')->where('id_user',$id)->update([
            'foto' => $input['foto'],
        ]);
        return redirect()->route('profil')->with('success', 'User Berhasil Ditambahkan');
    }


    public function logout(Request $request){
        if ($request->session()->has('login_user') ) {
            $request->session()->flush();
            return Redirect()->route('index');

        }
        return Redirect()->route('login');
    }
}
