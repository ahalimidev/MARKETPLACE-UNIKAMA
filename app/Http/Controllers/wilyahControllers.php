<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class wilyahControllers extends Controller
{
    public function provinsi(){
        $all = DB::select('select * from provinces');
        return $all;
    }

    public function kabupaten($id){
        $all = DB::select('select * from regencies where id_provinces = ?', [$id]);
        return $all;
    }

    public function kecamatan($id){
        $all = DB::select('select * from districts where id_regencies = ?', [$id]);
        return $all;
    }

    public function desa($id){
        $all = DB::select('select * from villages where id_districts = ?', [$id]);
        return $all;
    }
}
