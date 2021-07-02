<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Penduduk;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth']);
    // }
    public function __construct()
    {
        $this->middleware(['guest']);
    }
    public function index(){
        
        return view('dashboard');
    }

    public function RekapHome(Request $request){
        $stat = $request->stat;
        if($stat == 1){
            $data_periode = Periode::latest('created_at')->first();
            $periode = $data_periode->semester . " - " . $data_periode->year;

            $data = Kelurahan::get();
    
            foreach($data as $dt){
                $dt->total_keluarga = Penduduk::distinct('penduduk_kk')->where('kelurahan_id', $dt->kelurahan_id)->where('periode', $periode)->where('approved_status',3)->count();
            }
        }else{

            $data = Kelurahan::get();
    
            foreach($data as $dt){
                $dt->total_keluarga = Penduduk::distinct('penduduk_kk')->where('kelurahan_id', $dt->kelurahan_id)->where('approved_status',3)->count();
            }
        }
        
        // dd($data);
        return view('home_rekap')
        ->with('data',$data);
    }
}
