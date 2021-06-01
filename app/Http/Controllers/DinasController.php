<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;

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
}
