<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Penduduk;
use App\Models\RelasiPBA;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use App\Models\PendudukStatus;
use Illuminate\Support\Facades\DB;

class BAController extends Controller
{
    public function Create(Request $request){
        $kelurahan_id = $request->kelurahan_id;

        $data_periode = Periode::latest('created_at')->first();
        $periode = $data_periode->quarter . " - " . $data_periode->year;
        $data = Penduduk::where('kelurahan_id',$kelurahan_id)
        ->where('periode', 'none')->get();

        $usulan_count = 0;
        $perbaikan_count = 0;
        foreach($data as $dt){
            Penduduk::where('penduduk_id', $dt->penduduk_id)
            ->update([
                'periode' => $periode,
            ]);
            $usulan_count += 1;
            if($dt->penduduk_status != 0){
                $perbaikan_count += 1;
            }
        }

        BeritaAcara::create([
            'kelurahan_id' => $kelurahan_id,
            'periode' => $periode,
            'total_usulan' => $usulan_count,
            'total_perbaikan' => $perbaikan_count,
        ]);

        foreach($data as $dt){
            $ba_id = BeritaAcara::where('kelurahan_id',$kelurahan_id)->value('ba_id');
            $relasi_id = $ba_id . $dt->penduduk_id;
            RelasiPBA::create([
                'relasi_id' => $relasi_id,
                'penduduk_id' => $dt->penduduk_id,
                'ba_id' => $ba_id,
                'cek_dinas',
                'cek_mentri',
            ]);
        }

        return redirect()->route('pendudukdashboard');
    }

    public function UpdateView(Request $request, $ba_id){

        $data = DB::table('relasi_penduduk_ba')
        ->join('penduduk','relasi_penduduk_ba.penduduk_id','=','penduduk.penduduk_id');
        $data = $data->where('ba_id', $ba_id)
        ->get();

        foreach($data as $dt){
            $dt->status_deskripsi = DB::table('penduduk_status')->where('id',$dt->penduduk_status)->value('deskripsi');
        }
        // dd($data);
        return view('dinas.ba_update')
        ->with('data',$data)
        ->with('ba_id', $ba_id);
    }

    public function Update(Request $request){
        $penduduk_ids = $request->penduduk_id;
        $ba_id = $request->ba_id;
        // $data = DB::table('relasi_penduduk_ba')
        // ->join('penduduk','relasi_penduduk_ba.penduduk_id','=','penduduk.penduduk_id');
        // $data = $data->where('ba_id', $ba_id)
        // ->get();

        //approved
        foreach($penduduk_ids as $pi){
            Penduduk::where('penduduk_id', $pi)
            ->update([
                'approved_status' => 2,
            ]);
            RelasiPBA::where('penduduk_id', $pi)
            ->update([
                'cek_dinas' => 1,
            ]);
        }
        //not approved
        $data_denied = DB::table('relasi_penduduk_ba')
        ->join('penduduk','relasi_penduduk_ba.penduduk_id','=','penduduk.penduduk_id')
        ->where('ba_id', $ba_id)
        ->where('cek_dinas',0)
        ->get();

        foreach($data_denied as $dd){
            Penduduk::where('penduduk_id', $dd->penduduk_id)
            ->update([
                'approved_status' => 6,
            ]);
            RelasiPBA::where('penduduk_id', $dd->penduduk_id)
            ->update([
                'cek_dinas' => 1,
            ]);
        }

        // $data_denied = RelasiPBA::where('ba_id', $ba_id)
        // ->where('cek_dinas',0)->get();
        // foreach($data_denied as $dd){
        //     Penduduk::where('penduduk_id', $dd->penduduk_id)
        //     ->update([
        //         'approved_status' => 2,
        //     ]);
        // }
        // RelasiPBA::where('ba_id', $ba_id)
        // ->where('cek_dinas',0)
        // ->update([
        //     'cek_dinas' => 1,
        // ]);
        

        //update ba
        BeritaAcara::where('ba_id', $ba_id)
        ->update([
            'cek_dinas' => 1,
        ]);
        
        return redirect()->route('dinasdashboard');
    }
}
