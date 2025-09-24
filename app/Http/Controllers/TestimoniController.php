<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimoniController extends Controller
{
    public function create()
    {
        // Hanya user yang sudah login yang bisa akses
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memberikan testimoni.');
        }

        return view('pages.testimoni');
    }

    public function store(Request $request)
    {
        // Hanya user yang sudah login yang bisa submit
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memberikan testimoni.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'testimoni' => 'required|string|min:10'
        ]);

        Testimoni::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'pekerjaan' => $request->pekerjaan,
            'testimoni' => $request->testimoni,
            'is_approved' => false // Default tidak disetujui, menunggu admin
        ]);

        return redirect()->route('home')->with('success', 'Testimoni Anda berhasil dikirim dan sedang menunggu persetujuan admin.');
    }
}