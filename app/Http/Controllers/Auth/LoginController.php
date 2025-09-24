<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
public function showLoginForm()
{
    return view('layouts.app', ['page' => 'login']);
}

public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        
        // Cek status user
        if ($user->status === 'pending') {
            Auth::logout();
            return redirect()->back()->with('error', 'Akun Anda masih menunggu verifikasi admin.');
        }
        
        if ($user->status === 'rejected') {
            Auth::logout();
            return redirect()->back()->with('error', 'Akun Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.');
        }

        return redirect()->intended('/dashboard');
    }

    return redirect()->back()->with('error', 'Email atau password salah!');
}


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
    // Contoh di LoginController.php
public function index()
{
    return view('layouts.app', ['page' => 'login']);
}

}
