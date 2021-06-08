<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Kelurahan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ApprovedStatus;
use Illuminate\Support\Facades\DB;

class KelurahanController extends Controller
{
    public function PendudukDashboard(Request $request){

        $kelurahan = auth()->user()->username;
        $kelurahan_id = User::where('username', $kelurahan)->value('kelurahan_id');
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
        $kelurahan_id = User::where('username', $kelurahan)->value('kelurahan_id');
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
        // dd($request);
        $this->validate($request, [
            'NIK' => 'required',
            'KK' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'rt' => 'required',
            'rw' => 'required',
        ]);

        //VALIDATION//
        $nama = $request->nama;
        $nama = trim($nama);        //kurangin spasi dari sebelum kata pertama dan sesudah kata terakhir
        $nama = ucwords($nama);     //bikin semua kata di awali dengan huruf besar karena nama
        $nik_len = strlen($request->NIK);
        $kk_len = strlen($request->KK);

        //NIK DAN KK HARUS BERISI 16 DIGIT NANTINYA
        // if($nik_len != 16 || $kk_len != 16){
        //     return false;
        // }

        //Validasi nik dan nama
        $val_nik_nama = Penduduk::where("penduduk_nik", $request->NIK)
            ->where('penduduk_nama', '!=',$request->nama)
            ->first();              //cari nik sama dengan nama yang berbeda
        if($val_nik_nama){
            return "ERROR, nama yang telah dicantumkan berbeda dengan data NIK sebelumnya!";
            //response error
        }

        //Validasi nik sama pada periode yang sama
        $new_nik = $request->NIK;
        $val_new_nik = Penduduk::where('penduduk_nik', $new_nik)
        ->where('periode', 'none')
        ->first();
        if($val_new_nik){
            return "ERROR, NIK dan nama sudah didaftarkan sebelumnya!";
            //response error
        }

        //Validasi pembuatan status dan deskripsi jika pernah ada sebelum nya
        $val_status = Penduduk::where("penduduk_nik", $request->NIK)
            ->latest('created_at')
            ->first();
            
        if($val_status){

            
            if($val_status->approved_status == 2 || $val_status->approved_status == 3){
                $app_status = $val_status->approved_status;
                $deskripsi = $request->deskripsi;
            }
            if($val_status->approved_status == 6){
                $app_status = 5;
                $deskripsi = $val_status->deskripsi;
            }
            if($val_status->approved_status == 8){
                $app_status = 7;
                $deskripsi = $val_status->deskripsi;
            }

            //status nya penyesuaian
            $kelurahan_id = User::where('username', $request->username)->value('kelurahan_id');
            Penduduk::create([
                'penduduk_nik' => $request->NIK,
                'penduduk_kk' => $request->KK,
                'penduduk_id_bdt' => $request->BDT,
                'penduduk_nama' => $nama,
                'penduduk_alamat' => $request->alamat,
                // 'penduduk_status' => $status,
                'penduduk_deskripsi' => $deskripsi,
                'periode' => "none",
                'kelurahan_id' => $kelurahan_id,
                'approved_status' => $app_status,
                'rt' => $request->rt,
                'rw' => $request->rw,
            ]);
            
        }else{

            //BIKIN DATA BARU
            $kelurahan_id = User::where('username', $request->username)->value('kelurahan_id');
            Penduduk::create([
                'penduduk_nik' => $request->NIK,
                'penduduk_kk' => $request->KK,
                'penduduk_id_bdt' => $request->BDT,
                'penduduk_nama' => $nama,
                'penduduk_alamat' => $request->alamat,
                'penduduk_deskripsi' => $request->deskripsi,
                'periode' => "none",
                'kelurahan_id' => $kelurahan_id,
                'rt' => $request->rt,
                'rw' => $request->rw,
            ]);
        }


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
