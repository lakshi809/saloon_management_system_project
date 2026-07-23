<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, 
            [
                'username' => 'required',
                'password' => 'required|min:3'
            ],
            ['username.required' => 'Email or Username should be provided!']
        );

        $advanceEncryption = (new \App\MyResources\AdvanceEncryption($request->get('password'), "Nova6566", 256));
        $encryptedPassword = $advanceEncryption->encrypt();

        $userData = User::where('user_name', strtolower($request->get('username')))
                        ->where('password', $encryptedPassword)
                        ->first();

        if($userData){
            if($userData->status == 1){
                Auth::login($userData);
                session()->regenerate();
                return redirect()->route('dashboard');
            } else {
                return back()->with('warning', 'User has been suspended! Contact your System Administrator.');
            }
        } else {
            return back()->with('error', 'Incorrect login details! Check Username and Password');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/clientInterface');
    }

    public function signup()
    {
        return view('clientSignup');
    }
}