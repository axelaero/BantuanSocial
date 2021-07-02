<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Periode;
use App\Models\Penduduk;
use App\Models\Kelurahan;
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
        $jumlah_1 = Penduduk::where('kelurahan_id', $kelurahan_id)->latest('created_at')->distinct()->pluck('penduduk_nik');
        // return $jumlah_1;
        $jumlah[1] = 0;
        foreach($jumlah_1 as $j1){
            $exist = Penduduk::where('penduduk_nik', $j1)->latest('created_at')->first();
            if($exist->penduduk_status == 0){
                $jumlah[1] += 1;
            }
        }
        $jumlah[2] = Penduduk::latest('created_at')->distinct('penduduk_nik')->where('kelurahan_id', $kelurahan_id)->where('approved_status', 2)->count();
        $jumlah[3] = Penduduk::latest('created_at')->distinct('penduduk_nik')->where('kelurahan_id', $kelurahan_id)->where('approved_status', 6)->count();
        $jumlah[4] = Penduduk::latest('created_at')->distinct('penduduk_nik')->where('kelurahan_id', $kelurahan_id)->where('approved_status', 3)->count();
        $jumlah[5] = Penduduk::latest('created_at')->distinct('penduduk_nik')->where('kelurahan_id', $kelurahan_id)->where('approved_status', 7)->count();
        $jumlah[6] = Penduduk::latest('created_at')->distinct('penduduk_nik')->where('kelurahan_id', $kelurahan_id)->where('penduduk_status', 8)->count();
        $bandung = Penduduk::latest('created_at')->distinct('penduduk_nik')->where('kelurahan_id', $kelurahan_id)->where('penduduk_status', 1)->count();
        $luar_bandung = Penduduk::latest('created_at')->distinct('penduduk_nik')->where('kelurahan_id', $kelurahan_id)->where('penduduk_status', 2)->count();
        $jumlah[7] = $bandung + $luar_bandung;
        $jumlah[8] = Penduduk::latest('created_at')->distinct('penduduk_nik')->where('kelurahan_id', $kelurahan_id)->where('penduduk_status', 6)->count();
        $data_periode = Periode::latest('created_at')->first();
        $data = $data_periode->semester . " - " . $data_periode->year;
        $jumlah[9] = Penduduk::latest('created_at')->distinct('penduduk_nik')->where('kelurahan_id', $kelurahan_id)->where('periode', $data)->count();
        $jumlah[10] = Penduduk::latest('created_at')->distinct('penduduk_nik')->where('kelurahan_id', $kelurahan_id)->count();
        $jumlah[11] = Penduduk::latest('created_at')->distinct('penduduk_nik')->where('kelurahan_id', $kelurahan_id)->where('penduduk_status', 1)->count();
        $jumlah[11] += Penduduk::latest('created_at')->distinct('penduduk_nik')->where('kelurahan_id', $kelurahan_id)->where('penduduk_status', 2)->count();
        $jumlah[11] += Penduduk::latest('created_at')->distinct('penduduk_nik')->where('kelurahan_id', $kelurahan_id)->where('penduduk_status', 3)->count();
        $jumlah[11] += Penduduk::latest('created_at')->distinct('penduduk_nik')->where('kelurahan_id', $kelurahan_id)->where('penduduk_status', 4)->count();
        $jumlah[11] += Penduduk::latest('created_at')->distinct('penduduk_nik')->where('kelurahan_id', $kelurahan_id)->where('penduduk_status', 6)->count();
        // ->orwhere('penduduk_status', 2)
        // ->orwhere('penduduk_status', 3)
        // ->orwhere('penduduk_status', 4)
        // ->orwhere('penduduk_status', 6)
        // ->get();
        // dd($jumlah[11]);
        // dd($jumlah);
        return view('kelurahan.penduduk_report')->with('jumlah', $jumlah);
    }

    public function PendudukRekap(Request $request){
        $kelurahan = auth()->user()->username;
        $kelurahan_id = User::where('username', $kelurahan)->value('kelurahan_id');
        $iteration = DB::table('penduduk')
        ->join('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
        // ->leftjoin('approved_status','penduduk.approved_status','=','approved_status.id')
        ->where('kelurahan_id',$kelurahan_id);

        if($request->periode == 1){
            $iteration = $iteration->where('periode', $data_periode_txt);
        }else{
            $iteration = $iteration->where('periode','!=', 'none');
        }
        

        if($request->filter == 1){

            if($request->stats == 1){
                $iteration = $iteration->where('penduduk_status', 1)
                ->orwhere('penduduk_status', 2)
                ->orwhere('penduduk_status', 3)
                ->orwhere('penduduk_status', 4)
                ->orwhere('penduduk_status', 6);
            }else{
                $iteration = $iteration->where('penduduk_status', $request->stats);
            }
        }

        if($request->filter == 2){
            $iteration = $iteration->where('approved_status', $request->stats);
        }

        $data_periode = Periode::latest('created_at')->first();
        $data_periode_txt = $data_periode->semester . " - " . $data_periode->year;

        $iteration =  $iteration->distinct('penduduk_nik')->pluck('penduduk_nik');
        $data = array();
        foreach($iteration as $i){

            if($request->filter == 1){

                if($request->stats == 1){
                    $temp = DB::table('penduduk')
                    ->join('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
                    // ->leftjoin('approved_status','penduduk.approved_status','=','approved_status.id')
                    ->where('kelurahan_id',$kelurahan_id)
                    ->where('periode','!=', 'none')
                    ->where('penduduk_nik', $i)
                    ->latest('penduduk.created_at')
                    // ->where('penduduk_status', 1)
                    // ->orwhere('penduduk_status', 2)
                    // ->orwhere('penduduk_status', 3)
                    // ->orwhere('penduduk_status', 4)
                    // ->orwhere('penduduk_status', 6)
                    ->first();
                    if($temp){

                        if($temp->penduduk_status == 1 || $temp->penduduk_status == 2 || $temp->penduduk_status == 3 || $temp->penduduk_status == 4 || $temp->penduduk_status == 6){
                            array_push($data, $temp);
                        }
                    }
                }else{
                    $temp = DB::table('penduduk')
                    ->join('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
                    // ->leftjoin('approved_status','penduduk.approved_status','=','approved_status.id')
                    ->where('kelurahan_id',$kelurahan_id)
                    ->where('periode','!=', 'none')
                    ->where('penduduk_nik', $i)
                    ->latest('penduduk.created_at')
                    // ->where('penduduk_status', $request->stats)
                    ->first();
                    if($temp){

                        if($temp->penduduk_status == $request->stats){
                            array_push($data, $temp);
                        }
                    }
                }
            }
    
            if($request->filter == 2){
                $temp = DB::table('penduduk')
                ->join('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
                // ->leftjoin('approved_status','penduduk.approved_status','=','approved_status.id')
                ->where('kelurahan_id',$kelurahan_id)
                ->where('periode','!=', 'none')
                ->where('penduduk_nik', $i)
                ->latest('penduduk.created_at')
                ->first();
                // ->where('approved_status', $request->stats)
                if($temp){

                    if($temp->approved_status == $request->stats){
                        array_push($data, $temp);
                    }
                }
            }
            
            // $temp = DB::table('penduduk')
            // ->join('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
            // // ->leftjoin('approved_status','penduduk.approved_status','=','approved_status.id')
            // ->where('kelurahan_id',$kelurahan_id)
            // ->where('periode','!=', 'none')
            // ->where('penduduk_nik', $i)
            // ->latest('penduduk.created_at')
            // ->first();
            // dd($temp);
            // array_push($data, $temp);
        }
        // dd($data);
        foreach($data as $dt){
            $dt->approved_deskripsi = ApprovedStatus::where('id', $dt->approved_status)->value('deskripsi');
        }

        // dd($data);
        return view('kelurahan.penduduk_rekap')
        ->with('data',$data)
        ->with('kelurahan_id', $kelurahan_id);
    }

    public function CreateView(Request $request){

        $data = DB::table('periode')->latest('created_at')->first();
        $msg = 'none';
        return view('kelurahan.penduduk_create')
        ->with('data',$data)
        ->with('msg', $msg);
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

        // NIK DAN KK HARUS BERISI 16 DIGIT NANTINYA
        if($nik_len != 16 || $kk_len != 16){
            $data = DB::table('periode')->latest('created_at')->first();
            $msg = 'Panjang NIK dan KK tidak sesuai! (16 digit)';
            return view('kelurahan.penduduk_create')
            ->with('data',$data)
            ->with('msg', $msg);
            // return false;
        }

        //Validasi nik dan nama
        $val_nik_nama = Penduduk::where("penduduk_nik", $request->NIK)
            ->where('penduduk_nama', '!=',$request->nama)
            ->first();              //cari nik sama dengan nama yang berbeda
        if($val_nik_nama){
            $data = DB::table('periode')->latest('created_at')->first();
            $msg = 'Nama yang dicantumkan berbeda dengan NIK yang terdaftar!';
            return view('kelurahan.penduduk_create')
            ->with('data',$data)
            ->with('msg', $msg);
            // return "ERROR, nama yang telah dicantumkan berbeda dengan data NIK sebelumnya!";
            //response error
        }

        //Validasi id bdt, nik
        //if bdt existed
        if($request->BDT){
            $bdt_exist = Penduduk::where('penduduk_id_bdt', $request->BDT)->where('penduduk_nik', $request->NIK)->latest('created_at')->first();
            if(!$bdt_exist){
                $data = DB::table('periode')->latest('created_at')->first();
                $msg = 'NIK dan ID BDT Tidak sesuai!';
                return view('kelurahan.penduduk_create')
                ->with('data',$data)
                ->with('msg', $msg);
            }
        }else{
        //if bdt not existed
            $bdt_exist = Penduduk::where('penduduk_nik', $request->NIK)->latest('created_at')->value('penduduk_id_bdt');
            if($bdt_exist != null){
                $data = DB::table('periode')->latest('created_at')->first();
                $msg = 'Masukan ID BDT yang terdaftar!';
                return view('kelurahan.penduduk_create')
                ->with('data',$data)
                ->with('msg', $msg);
                
            }
        }

        //Validasi pembuatan status dan deskripsi jika pernah ada sebelum nya
        $val_status = Penduduk::where("penduduk_nik", $request->NIK)
            ->latest('created_at')
            ->first();
            
        if($val_status){

            if($val_status->approved_status == 2 || $val_status->approved_status == 3){
                $app_status = 4;
                $deskripsi = $request->deskripsi;
                $status = 7;
            }
            if($val_status->approved_status == 6 || $val_status->approved_status == 7){
                $app_status = 5;
                $deskripsi = $request->deskripsi;
                $status = 7;
            }

            //status nya penyesuaian
            $kelurahan_id = User::where('username', $request->username)->value('kelurahan_id');
            Penduduk::create([
                'penduduk_nik' => $request->NIK,
                'penduduk_kk' => $request->KK,
                'penduduk_id_bdt' => $request->BDT,
                'penduduk_nama' => $nama,
                'penduduk_alamat' => $request->alamat,
                'penduduk_status' => $status,
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

    public function Delete($penduduk_id){

        Penduduk::where('penduduk_id',$penduduk_id)->delete();

        return redirect()->route('pendudukdashboard');
    }
}
