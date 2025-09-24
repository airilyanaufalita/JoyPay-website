<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Halaman setelah user register tapi belum verifikasi email
     */
    public function notice()
    {
        return view('auth.verify-email'); // buat file view ini
    }

    /**
     * Verifikasi email ketika user klik link di email
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill(); // tandai email sudah diverifikasi

        return redirect()->route('home')->with('success', 'Email berhasil diverifikasi!');
    }

    /**
     * Kirim ulang email verifikasi
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Link verifikasi baru telah dikirim ke email Anda.');
    }
}
