<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }
    public function index(){
        return view('auth.login');
    }

    public function store(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if(!Auth::attempt($request->only('username','password'), $request->remember)){
            return back()->with('status', 'Invalid login details');
        }

        $role = User::where('username', $request->username)->value('role');
        if($role == 1){
            return redirect()->route('admindashboard');
        }

        return redirect()->route('home');
    }
}
