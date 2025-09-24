<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WinnerController extends Controller
{
    /**
     * Display a listing of the winners.
     */
    public function index(Request $request)
    {
        $query = DB::table('pemenang');

        // Filter berdasarkan nama
        if ($request->has('nama') && $request->nama != '') {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        // Filter berdasarkan kloter
        if ($request->has('kloter') && $request->kloter != '') {
            $query->where('kloter_nama', 'like', '%' . $request->kloter . '%');
        }

        $winners = $query->orderBy('tanggal_menang', 'desc')->paginate(10);
        
        // Ambil daftar kloter untuk filter dropdown
        $kloters = DB::table('pemenang')->distinct()->pluck('kloter_nama');

        return view('layouts.app', [
            'page' => 'pemenang',
            'title' => 'Pemenang Kloter',
            'winners' => $winners,
            'kloters' => $kloters,
            'filters' => $request->only(['nama', 'kloter'])
        ]);
    }

    /**
     * Display the specified winner.
     */
    public function show($id)
    {
        $winner = DB::table('pemenang')->where('id', $id)->first();

        if (!$winner) {
            abort(404);
        }

        return view('layouts.app', [
            'page' => 'pemenang-detail',
            'title' => 'Detail Pemenang',
            'winner' => $winner
        ]);
    }
}