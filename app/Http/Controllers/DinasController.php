<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Penduduk;
use App\Models\Kelurahan;
use App\Models\RelasiPBA;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use App\Models\ApprovedStatus;
use App\Models\PendudukStatus;
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
        ->leftjoin('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
        ->where('approved_status', 2)
        ->where('cek_dinas',1)
        ->where('cek_mentri',0);
        if($request->searchnik){
            $data = $data->where('penduduk_nik', $request->searchnik);
        }
        $data = $data->get();
        // dd($data);
        return view('dinas.mentridashboard')
        ->with('data',$data);
    }

    public function MentriUpdate(Request $request){
        
        $bdt_s = $request->bdt;
        $approved_ids = $request->penduduk_id_approved;
        $denied_ids = $request->penduduk_id_rejected;
        $deskripsi = $request->deskripsi;

        foreach($bdt_s as $bdt){
            
            $id = $bdt["penduduk_id"];
            $id_bdt = $bdt["data"];
            if($id_bdt){
                Penduduk::where('penduduk_id', $id)
                ->update([
                    'penduduk_id_bdt' => $id_bdt,
                ]);
            }      
        }

        if($approved_ids){
            foreach($approved_ids as $ai){
                Penduduk::where('penduduk_id', $ai)
                ->where('penduduk_id_bdt', "!=", null)
                ->update([
                    'approved_status' => 3,
                ]);
                $exist = Penduduk::where('penduduk_id', $ai)->where('penduduk_id_bdt', "!=", null)->where('approved_status',3)->first();
                if($exist){
                    RelasiPBA::where('penduduk_id', $ai)
                    ->update([
                        'cek_mentri' => 1,
                    ]);
                }
            }
        }
        if($denied_ids){
            foreach($denied_ids as $di){
                Penduduk::where('penduduk_id', $di)
                // ->where('penduduk_id_bdt', "!=", null)
                ->update([
                    'approved_status' => 7,
                ]);
                // $exist = Penduduk::where('penduduk_id', $ai)->where('penduduk_id_bdt', "!=", null)->where('approved_status',7)->first();
                // if($exist){
                RelasiPBA::where('penduduk_id', $di)
                ->update([
                    'cek_mentri' => 1,
                ]);
                // }
            }
        }
        foreach($deskripsi as $des){
            
            $id = $des["penduduk_id"];
            $data = $des["data"];
            if($data){
                Penduduk::where('penduduk_id', $id)
                ->where('approved_status', 7)
                // ->where('penduduk_id_bdt', "!=", null)
                ->update([
                    'penduduk_deskripsi' => $data,
                ]);
            }      
        }
        //if approved, deskripsi change to "-", add bdt_id
        return redirect()->route('dinasreport');
    }

    public function PeriodeView(Request $request){
        $data_periode = Periode::latest('created_at')->first();
        $data = $data_periode->semester . " - " . $data_periode->year;

        $exist = 1;
        $cek_dinas_check = RelasiPBA::where('cek_dinas', 0)->first();
        if($cek_dinas_check){
            $exist = 0;
        }
        
        return view('dinas.periode')
        ->with('data', $data)
        ->with('exist', $exist);
    }

    public function PeriodeCreate(Request $request){
        $year = date('Y');
        $quarter = Periode::where('year', $year)->count();
        $quarter += 1;
        Periode::create([
            'semester' => "S" . $quarter,
            'year' => $year,
        ]);
        
        return redirect()->route('periode');
    }

    public function DinasReport(Request $request){

        // $iteration = DB::table('penduduk')
        // ->join('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
        // // ->leftjoin('approved_status','penduduk.approved_status','=','approved_status.id')
        // // ->where('kelurahan_id',$kelurahan_id)
        // ->where('periode','!=', 'none')
        // ->distinct('penduduk_nik')
        // ->pluck('penduduk_nik');
        // $data = array();
        // foreach($iteration as $i){
        //     $temp = DB::table('penduduk')
        //     ->join('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
        //     // ->leftjoin('approved_status','penduduk.approved_status','=','approved_status.id')
        //     // ->where('kelurahan_id',$kelurahan_id)
        //     ->where('periode','!=', 'none')
        //     ->where('penduduk_nik', $i)
        //     ->latest('penduduk.created_at')
        //     ->first();
        //     array_push($data, $temp);
        //     // dd($temp);
        // }
        // // dd($data);
        // foreach($data as $dt){
        //     $dt->approved_deskripsi = ApprovedStatus::where('id', $dt->approved_status)->value('deskripsi');
        // }
        // return view('dinas.dinas_report')
        // ->with('data',$data);
        $data = Kelurahan::get();

        // foreach($data as $dt){
        //     $dt->kelurahan_nama = Kelurahan::where('kelurahan_id',$dt->kelurahan_id)->value('kelurahan_nama');
        // }
        // dd($data);
        return view('dinas.dinas_report')
        ->with('data',$data);

    }

    public function PendudukRekap(Request $request){
        // $kelurahan_id = $request->kelurahan_id;
        // $iteration = DB::table('penduduk')
        // ->join('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
        // // ->leftjoin('approved_status','penduduk.approved_status','=','approved_status.id')
        // ->where('kelurahan_id',$kelurahan_id)
        // ->where('periode','!=', 'none');

        // if($request->filter == 1){

        //     if($request->stats == 1){
        //         $iteration = $iteration->where('penduduk_status', 1)->orwhere('penduduk_status', 2);
        //     }else{
        //         $iteration = $iteration->where('penduduk_status', $request->stats);
        //     }
        // }

        // if($request->filter == 2){
        //     $iteration = $iteration->where('approved_status', $request->stats);
        // }

        // $data_periode = Periode::latest('created_at')->first();
        // $data_periode_txt = $data_periode->semester . " - " . $data_periode->year;

        // if($request->periode == 1){
        //     $iteration = $iteration->where('periode', $data_periode_txt);
        // }

        // $iteration =  $iteration->distinct('penduduk_nik')->pluck('penduduk_nik');
        // $data = array();
        // foreach($iteration as $i){
        //     $temp = DB::table('penduduk')
        //     ->join('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
        //     // ->leftjoin('approved_status','penduduk.approved_status','=','approved_status.id')
        //     ->where('kelurahan_id',$kelurahan_id)
        //     ->where('periode','!=', 'none')
        //     ->where('penduduk_nik', $i)
        //     ->latest('penduduk.created_at')
        //     ->first();
        //     array_push($data, $temp);
        //     // dd($temp);
        // }
        // // dd($data);
        // foreach($data as $dt){
        //     $dt->approved_deskripsi = ApprovedStatus::where('id', $dt->approved_status)->value('deskripsi');
        // }
        $kelurahan_id = $request->kelurahan_id;
        $name = Kelurahan::where('kelurahan_id', $kelurahan_id)->value('kelurahan_nama');
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
        // dd($jumlah);
        return view('dinas.dinas_rekap')->with('jumlah', $jumlah)->with('kelurahan_id', $kelurahan_id)->with('name',$name);

        // dd($data);
        // return view('dinas.dinas_rekap')
        // ->with('data',$data)
        // ->with('kelurahan_id', $kelurahan_id);
    }

    public function PendudukRekapStatus(Request $request){
        if($request->filter == 1){
            if($request->stats == 1){
                $msg = "Data Perbaikan";
            }else{
                $msg = "Data Baru";
            }
        }
        if($request->filter == 2){
            if($request->filter == 2){
                if($request->stats == 2){
                    $msg = ucwords('approved dinsos');
                }
                if($request->stats == 6){
                    $msg = ucwords('ditolak dinsos');
                }
                if($request->stats == 3){
                    $msg = ucwords('masuk dtks');
                }
                if($request->stats == 7){
                    $msg = ucwords('ditolak dtks');
                }
            }
        }
        if($request->periode == 1){
            $msg = "Perdiode Ini";
        }
        if(!$request->periode && !$request->filter){
            $msg = "Seluruh Data";
        }

        $kelurahan_id = $request->kelurahan_id;
        $iteration = DB::table('penduduk')
        ->join('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
        // ->leftjoin('approved_status','penduduk.approved_status','=','approved_status.id')
        ->where('kelurahan_id',$kelurahan_id);
        if($request->searchnik){
            $iteration = $iteration->where('penduduk_nik', $request->searchnik);
        }
        $data_periode = Periode::latest('created_at')->first();
        $data_periode_txt = $data_periode->semester . " - " . $data_periode->year;
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

        // if($request->periode == 1){
        //     $iteration = $iteration->where('periode', $data_periode_txt);
        // }

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
                    // $msg = 'Data Perbaikan';
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
                    // $msg = ucwords("Data Baru");
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
                // $msg = ApprovedStatus::where('id', $temp->penduduk_status)->value('deskripsi');
                // $msg = ucwords($msg);
                if($temp){

                    if($temp->approved_status == $request->stats){
                        array_push($data, $temp);
                    }
                }
            }
            
            if($request->periode == 1){
                $temp = DB::table('penduduk')
                ->join('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
                // ->leftjoin('approved_status','penduduk.approved_status','=','approved_status.id')
                ->where('kelurahan_id',$kelurahan_id)
                ->where('periode', $data_periode_txt)
                ->where('penduduk_nik', $i)
                ->latest('penduduk.created_at')
                ->first();
                // ->where('approved_status', $request->stats)
                // $msg = "Perdiode Ini";
                if($temp){
                    array_push($data, $temp);
                }
            }

            if(!$request->periode && !$request->filter){
                $temp = DB::table('penduduk')
                ->join('penduduk_status','penduduk.penduduk_status','=','penduduk_status.id')
                // ->leftjoin('approved_status','penduduk.approved_status','=','approved_status.id')
                ->where('kelurahan_id',$kelurahan_id)
                ->where('periode','!=', 'none')
                ->where('penduduk_nik', $i)
                ->latest('penduduk.created_at')
                ->first();
                // $msg = "Seluruh Data";
                if($temp){
                    array_push($data, $temp);
                }
            }
        }
        // dd($data);
        foreach($data as $dt){
            $dt->approved_deskripsi = ApprovedStatus::where('id', $dt->approved_status)->value('deskripsi');
        }
        
        // dd($data);
        return view('dinas.dinas_rekap_status')
        ->with('data',$data)
        ->with('kelurahan_id', $kelurahan_id)
        ->with('msg', $msg)
        ->with('filter', $request->filter)
        ->with('stats', $request->stats);
    }
}
