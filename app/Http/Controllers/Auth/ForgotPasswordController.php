<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    // Tampilkan form forgot password
    public function showForgotForm()
    {
        return view('layouts.app', [
            'title' => 'Forgot Password',
            'page' => 'forgot-password'
        ]);
    }

    public function checkUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::where('name', $request->name)
                    ->where('email', $request->email)
                    ->first();

        if ($user) {
            // Jika cocok → arahkan ke reset password
            return redirect()->route('reset.password', ['name' => $user->name])
                             ->with('success', 'Data cocok! Silakan reset password Anda.');
        } else {
            return back()->with('error', 'name dan Email tidak cocok!');
        }
    }
}
