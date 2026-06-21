<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister(){
        return view('auth.register');
    }

    public function saveRegister(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed'
        ]);
        User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password)
        ]);
        return redirect('/register');
    }
    public function showLogin(){
        return view('auth.login');
    }
    public function checkLogin(Request $request){
        $credentials=$request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect('/login');
        }
        return back()->withErrors([
            'email'=>'invalid credentials'
        ]);
    }
}
