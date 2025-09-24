<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    // Tampilkan form reset
    public function showResetForm($name)
    {
        return view('layouts.app', [
            'title' => 'Reset Password',
            'page' => 'reset-password',
            'name' => $name
        ]);
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::where('name', $request->name)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login.');
        } else {
            return back()->with('error', 'User tidak ditemukan!');
        }
    }
}
