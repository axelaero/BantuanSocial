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

        $ba_id = BeritaAcara::latest('created_at')
        ->where('kelurahan_id', $kelurahan_id)
        ->value('ba_id');
        foreach($data as $dt){
            $relasi_id = $ba_id . $dt->penduduk_id;
            RelasiPBA::create([
                'relasi_id' => $relasi_id,
                'penduduk_id' => $dt->penduduk_id,
                'ba_id' => $ba_id,
                'cek_dinas',
                'cek_mentri',
            ]);
        }
        // $this->printPDF($ba_id);

        return view('dinas.ba_printview')
        ->with('ba_id', $ba_id);
    }

    public function UpdateView(Request $request){

        $ba_id = $request->ba_id;
        $data = DB::table('relasi_penduduk_ba')
        ->join('penduduk','relasi_penduduk_ba.penduduk_id','=','penduduk.penduduk_id');
        $data = $data->where('ba_id', $ba_id);
        if($request->searchnik){
            $data = $data->where('penduduk_nik', $request->searchnik);
        }
        $data = $data->where('cek_dinas', 0)->get();
        $kelurahan_id = BeritaAcara::latest('created_at')->where('ba_id',$ba_id)->value('kelurahan_id');
        $nama = Kelurahan::where('kelurahan_id',$kelurahan_id)->value('kelurahan_nama');
        $periode = BeritaAcara::latest('created_at')->where('ba_id',$ba_id)->value('periode');
        $part = BeritaAcara::latest('created_at')->where('ba_id',$ba_id)->value('part');

        foreach($data as $dt){
            $dt->status_deskripsi = DB::table('penduduk_status')->where('id',$dt->penduduk_status)->value('deskripsi');
        }
        // dd($data);
        // dd($data);
        return view('dinas.ba_update')
        ->with('data',$data)
        ->with('ba_id', $ba_id)
        ->with('nama', $nama)
        ->with('periode', $periode)
        ->with('part', $part);
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
        $bacheck = RelasiPBA::where('ba_id', $ba_id)->where('cek_dinas', 0)->first();
        if(!$bacheck){
            BeritaAcara::where('ba_id', $ba_id)
            ->update([
                'cek_dinas' => 1,
            ]);
        }
        
        return redirect()->route('dinasreport');
    }

    // public function printview(){
    //     return view('dinas.printview');
    // }

    public function printPDF(Request $request){
        $ba_id = $request->ba_id;
        // $ba_id = BeritaAcara::latest()->value('ba_id');
        $kelurahan_id = BeritaAcara::where('ba_id',$ba_id)->distinct('kelurahan_id')->pluck('kelurahan_id');
        $data = DB::table('penduduk')
        ->leftjoin('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
        ->leftjoin('relasi_penduduk_ba', 'penduduk.penduduk_id', '=', 'relasi_penduduk_ba.penduduk_id')
        // ->leftjoin('approved_status','penduduk.approved_status','=','approved_status.id')
        ->where('ba_id',$ba_id)
        // ->where('periode', 'none')
        ->get();
        // dd($data);
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
        // $pdf->getDomPDF()->setHttpContext(
        //     stream_context_create([
        //         'ssl' => [
        //             'allow_self_signed'=> TRUE,
        //             'verify_peer' => FALSE,
        //             'verify_peer_name' => FALSE,
        //         ]
        //     ])
        // );

        $kelurahan_nama = Kelurahan::where('kelurahan_id', $kelurahan_id)->value('kelurahan_nama');
        $kelurahan_nama = ucwords($kelurahan_nama);
        $part = BeritaAcara::where('ba_id',$ba_id)->value('part');
        $file_name = "Bansos_" . $kelurahan_nama . "_Part-" . $part . "_tgl(" . date('d-m-y') . ").pdf";
    	return $pdf->download($file_name);

    }
}
