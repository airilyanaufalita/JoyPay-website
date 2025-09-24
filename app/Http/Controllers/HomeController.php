<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 3 testimoni terbaru yang sudah disetujui
        $testimonis = Testimoni::where('is_approved', true)
                              ->orderBy('created_at', 'desc')
                              ->limit(3)
                              ->get();

        return view('layouts.app', [
            'page' => 'home',
            'title' => 'Beranda',
            'testimonis' => $testimonis
        ]);
    }
}