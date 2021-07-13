<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function AdminDashboard(){

        $users = DB::table('users')
        ->leftjoin('kelurahan','users.kelurahan_id','=','kelurahan.kelurahan_id')
        ->where('role','!=',0)
        ->where('role','!=',1)
        ->get();

        return view('admin.admindashboard')
        ->with('users', $users);
    }
}
