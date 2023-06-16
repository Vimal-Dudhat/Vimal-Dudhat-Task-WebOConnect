<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = User::find(Auth::id());
            $user->is_qr_generate = 1;
            $user->save();

            $url = url('user/edit?email='.$user->email);
            return view('qrCode',compact('url'));
        }
        return back()->withErrors([
            'password' => 'The provided credentials do not match our records.',
        ]);
        // return back()->with('error','The provided credentials do not match our records.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
