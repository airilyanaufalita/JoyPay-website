<?php

namespace App\Http\Controllers;

class PendapatanController extends Controller
{
    public function index()
    {
        // Data dummy untuk kloter
        $kloters = [
            [
                'name' => 'Arisan Berkah',
                'nominal' => 500000,
                'slot_number' => 10,
                'pembayaran_bulanan' => 46667,
                'status' => 'menunggu',
                'tanggal_giliran' => '2025-10-01',
                'pendapatan' => 0, // Akan dihitung berdasarkan status
            ],
        ];

        // Hitung pendapatan sederhana (jika status 'diterima', pendapatan = nominal)
        foreach ($kloters as &$kloter) {
            $kloter['pendapatan'] = $kloter['status'] === 'diterima' ? $kloter['nominal'] : 0;
        }

        return view('pages.pendapatan', compact('kloters'));
    }
}