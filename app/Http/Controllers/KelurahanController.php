<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use App\Models\ApprovedStatus;
use Illuminate\Support\Facades\DB;

class KelurahanController extends Controller
{
    public function PendudukDashboard(Request $request){

        $kelurahan = auth()->user()->username;
        $kelurahan_id = Kelurahan::where('kelurahan_nama',$kelurahan)->value('kelurahan_id');
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
        return view('kelurahan.pendudukdashboard')
        ->with('data',$data)
        ->with('kelurahan_id', $kelurahan_id);
    }

    public function PendudukReport(Request $request){

        $kelurahan = auth()->user()->username;
        $kelurahan_id = Kelurahan::where('kelurahan_nama',$kelurahan)->value('kelurahan_id');
        $data = DB::table('penduduk')
        ->leftjoin('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
        // ->leftjoin('approved_status','penduduk.approved_status','=','approved_status.id')
        ->where('kelurahan_id',$kelurahan_id)
        ->where('periode','!=', 'none')
        ->get();
        foreach($data as $dt){
            $dt->approved_deskripsi = ApprovedStatus::where('id', $dt->approved_status)->value('deskripsi');
        }
        // dd($data);
        return view('kelurahan.penduduk_report')
        ->with('data',$data)
        ->with('kelurahan_id', $kelurahan_id);
    
    }

    public function CreateView(Request $request){

        $data = DB::table('periode')->latest('created_at')->first();

        return view('kelurahan.penduduk_create')
        ->with('data',$data);
    }

    public function Create(Request $request){

        $this->validate($request, [
            'NIK' => 'required',
            'KK' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'rt' => 'required',
            'rw' => 'required',
        ]);
        
        $kelurahan_id = Kelurahan::where('kelurahan_nama', $request->kelurahan)->value('kelurahan_id');

        Penduduk::create([
            'penduduk_nik' => $request->NIK,
            'penduduk_kk' => $request->KK,
            'penduduk_id_bdt' => $request->BDT,
            'penduduk_nama' => $request->nama,
            'penduduk_alamat' => $request->alamat,
            'penduduk_deskripsi' => $request->deskripsi,
            'periode' => "none",
            'kelurahan_id' => $kelurahan_id,
            'rt' => $request->rt,
            'rw' => $request->rw,
        ]);

        return redirect()->route('pendudukdashboard');
    }

    public function UpdateView(Request $request, $id){

        $penduduk = Penduduk::where('penduduk_id',$id)->value('penduduk_nama');

        return view('kelurahan.penduduk_update')
        ->with('penduduk_nama', $penduduk)
        ->with('penduduk_id', $id);
    }

    public function Update(Request $request){
        $penduduk_id = $request->penduduk_id;
        $penduduk_status_id = $request->penduduk_status_id;

        Penduduk::where('penduduk_id',$penduduk_id)->update([
            'penduduk_status' => $penduduk_status_id,
        ]);

        return redirect()->route('pendudukdashboard');
    }

    public function Delete(Request $request){
        $penduduk_id = $request->penduduk_id;

        Penduduk::where('penduduk_id',$penduduk_id)->delete();

        return redirect()->route('pendudukdashboard');
    }
}
