<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Kelurahan;
use App\Models\BeritaAcara;
use App\Models\RelasiPBA;
use App\Models\Penduduk;
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
        ->where('cek_mentri',0)
        ->get();
        // dd($data);
        return view('dinas.mentridashboard')
        ->with('data',$data);
    }

    public function MentriUpdate(Request $request){
        
        $approved_ids = $request->penduduk_id_approved;
        $denied_ids = $request->penduduk_id_rejected;
        $deskripsi = $request->deskripsi;
        if($approved_ids){
            foreach($approved_ids as $ai){
                Penduduk::where('penduduk_id', $ai)
                ->update([
                    'approved_status' => 3,
                ]);
                RelasiPBA::where('penduduk_id', $ai)
                ->update([
                    'cek_mentri' => 1,
                ]);
            }
        }
        if($denied_ids){
            foreach($denied_ids as $di){
                Penduduk::where('penduduk_id', $di)
                ->update([
                    'approved_status' => 8,
                ]);
                RelasiPBA::where('penduduk_id', $di)
                ->update([
                    'cek_mentri' => 1,
                ]);
            }
        }
        foreach($deskripsi as $des){
            
            $id = $des["penduduk_id"];
            $data = $des["data"];
            if($data){
                Penduduk::where('penduduk_id', $id)
                ->update([
                    'penduduk_deskripsi' => $data,
                ]);
            }      
        }
        return redirect()->route('mentridashboard');
    }

    public function PeriodeView(Request $request){
        $data_periode = Periode::latest('created_at')->first();
        $data = $data_periode->quarter . " - " . $data_periode->year;
        return view('dinas.periode')
        ->with('data', $data);
    }

    public function PeriodeCreate(Request $request){
        $year = date('Y');
        $quarter = Periode::where('year', $year)->count();
        $quarter += 1;
        Periode::create([
            'quarter' => "Q" . $quarter,
            'year' => $year,
        ]);
        
        return redirect()->route('periode');
    }
}
