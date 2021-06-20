<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Periode;
use App\Models\Penduduk;
use App\Models\Kelurahan;
use App\Models\RelasiPBA;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use App\Models\ApprovedStatus;
use App\Models\PendudukStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;

class BAController extends Controller
{
    public function Create(Request $request){
        $kelurahan_id = $request->kelurahan_id;

        $data_periode = Periode::latest('created_at')->first();
        $periode = $data_periode->semester . " - " . $data_periode->year;
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

        $latest_data = BeritaAcara::where('kelurahan_id', $kelurahan_id)
        ->where('periode', $periode)
        ->latest('created_at')
        ->first();
        if($latest_data){
            $part = $latest_data->part + 1;
            BeritaAcara::create([
                'kelurahan_id' => $kelurahan_id,
                'periode' => $periode,
                'total_usulan' => $usulan_count,
                'total_perbaikan' => $perbaikan_count,
                'part' => $part,
            ]);
        }else{
            BeritaAcara::create([
                'kelurahan_id' => $kelurahan_id,
                'periode' => $periode,
                'total_usulan' => $usulan_count,
                'total_perbaikan' => $perbaikan_count,
            ]);
        }

        foreach($data as $dt){
            $ba_id = BeritaAcara::latest('created_at')->value('ba_id');
            $relasi_id = $ba_id . $dt->penduduk_id;
            RelasiPBA::create([
                'relasi_id' => $relasi_id,
                'penduduk_id' => $dt->penduduk_id,
                'ba_id' => $ba_id,
                'cek_dinas',
                'cek_mentri',
            ]);
        }

        return redirect()->route('pendudukreport');
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
        // dd($data);
        return view('dinas.ba_update')
        ->with('data',$data)
        ->with('ba_id', $ba_id);
    }

    public function Update(Request $request){
        // dd($request);

        $ba_id = $request->ba_id;
        $approved_ids = $request->penduduk_id_approved;
        $denied_ids = $request->penduduk_id_rejected;
        $deskripsi = $request->deskripsi;

        if($approved_ids){
            foreach($approved_ids as $ai){
                Penduduk::where('penduduk_id', $ai)
                ->update([
                    'approved_status' => 2,
                ]);
                RelasiPBA::where('penduduk_id', $ai)
                ->update([
                    'cek_dinas' => 1,
                ]);
            }
        }
        if($denied_ids){
            foreach($denied_ids as $di){
                Penduduk::where('penduduk_id', $di)
                ->update([
                    'approved_status' => 6,
                ]);
                RelasiPBA::where('penduduk_id', $di)
                ->update([
                    'cek_dinas' => 1,
                ]);
            }
        }
        
        foreach($deskripsi as $des){
            
            $id = $des["penduduk_id"];
            $data = $des["data"];
            if($data){
                Penduduk::where('penduduk_id', $id)
                ->where('approved_status', 6)
                ->update([
                    'penduduk_deskripsi' => $data,
                ]);
            }      
        }
        //update ba
        BeritaAcara::where('ba_id', $ba_id)
        ->update([
            'cek_dinas' => 1,
        ]);
        
        return redirect()->route('dinasreport');
    }

    public function printPDF(Request $request){
        // $ba_id = $request->ba_id;

        $kelurahan_id = 2;
        $data = DB::table('penduduk')
        ->leftjoin('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
        // ->leftjoin('approved_status','penduduk.approved_status','=','approved_status.id')
        ->where('kelurahan_id',$kelurahan_id)
        ->where('periode', 'none')
        ->get();
        foreach($data as $dt){
            $dt->approved_deskripsi = ApprovedStatus::where('id', $dt->approved_status)->value('deskripsi');
        }
        // dd($data);
        // return view('kelurahan.pendudukdashboard')
        // ->with('data',$data)
        // ->with('kelurahan_id', $kelurahan_id);
        
    	// $pegawai = Pegawai::all();
        $kelurahan = Kelurahan::where('kelurahan_id',$kelurahan_id)->first();
        // dd($kelurahan);
    	$pdf = PDF::loadview('dinas.ba_print',[
            'data'=>$data,
            'kelurahan'=>$kelurahan,
        ]);
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed'=> TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );
    	return $pdf->download('bansos.pdf');

        return view('dinas.ba_print')
        ->with('data',$data);
    }
}
