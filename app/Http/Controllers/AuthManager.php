<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// ho creato le funzioni per la registrazione, login e il logout
class AuthManager extends Controller
{
    function login(){
        return view('login/login');
    }

    
    function register(){
        return view('login/register');
    }

    function loginPost(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credenziali = $request->only('email', 'password');
        if(Auth::attempt($credenziali)){
            error_log('successo');
            return redirect()->intended(route('home'))->with("success","Login è andato a buon fine");
        }
        error_log('errore');

        return redirect(route('login'))->with("error","Login details are not valid");
    }

    function registerPost(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $data['name'] = $request ->name;
        $data['email'] = $request ->email;
        $data['password'] = Hash::make($request ->password);
        $user = User::create($data);
        if(!$user){
            return redirect(route('register'))->with("error","registrazione fallita");
        }
            return redirect(route('login'))->with("success","Registrazione effettuata");

    }

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('login/login'));
    }
}

