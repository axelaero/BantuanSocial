<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DinasController extends Controller
{
    public function DinasDashboard(Request $request){

        $data = BeritaAcara::where('cek_dinas', 0)->get();

        foreach($data as $dt){
            $dt->kelurahan_nama = Kelurahan::where('kelurahan_id',$dt->kelurahan_id)->value('kelurahan_nama');
        }
        // dd($data);
        return view('dinas.dinasdashboard')
        ->with('data',$data);
    }

    public function MentriDashboard(Request $request){

        $data = DB::table('penduduk')
        ->join('relasi_penduduk_ba', 'penduduk.penduduk_id','=','relasi_penduduk_ba.penduduk_id')
        ->where('approved_status', 2)
        ->where('cek_dinas',1)
        ->get();
        // dd($data);
        return view('dinas.mentridashboard')
        ->with('data',$data);
    }
}
