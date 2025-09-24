<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Winner;
use Carbon\Carbon;

class WinnersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $winners = [
            [
                'nama_pemenang' => 'Budi Santoso',
                'email_pemenang' => 'budi.santoso@email.com',
                'no_telepon' => '08123456789',
                'kloter_name' => 'Kloter Emas A',
                'periode' => 1,
                'jumlah_hadiah' => 5000000,
                'tanggal_undian' => Carbon::now()->subDays(30),
                'status' => 'paid',
                'catatan' => 'Pembayaran telah diterima dengan baik'
            ],
            [
                'nama_pemenang' => 'Siti Nurhaliza',
                'email_pemenang' => 'siti.nurhaliza@email.com',
                'no_telepon' => '08234567890',
                'kloter_name' => 'Kloter Perak B',
                'periode' => 2,
                'jumlah_hadiah' => 3000000,
                'tanggal_undian' => Carbon::now()->subDays(20),
                'status' => 'confirmed',
                'catatan' => 'Menunggu proses pembayaran'
            ],
            [
                'nama_pemenang' => 'Ahmad Wijaya',
                'email_pemenang' => 'ahmad.wijaya@email.com',
                'no_telepon' => '08345678901',
                'kloter_name' => 'Kloter Perunggu C',
                'periode' => 1,
                'jumlah_hadiah' => 2000000,
                'tanggal_undian' => Carbon::now()->subDays(15),
                'status' => 'pending',
                'catatan' => 'Sedang dalam proses verifikasi'
            ],
            [
                'nama_pemenang' => 'Dewi Lestari',
                'email_pemenang' => 'dewi.lestari@email.com',
                'no_telepon' => '08456789012',
                'kloter_name' => 'Kloter Emas A',
                'periode' => 3,
                'jumlah_hadiah' => 5000000,
                'tanggal_undian' => Carbon::now()->subDays(10),
                'status' => 'confirmed',
                'catatan' => 'Pemenang periode 3 kloter emas'
            ],
            [
                'nama_pemenang' => 'Rudi Hermawan',
                'email_pemenang' => 'rudi.hermawan@email.com',
                'no_telepon' => '08567890123',
                'kloter_name' => 'Kloter Diamond D',
                'periode' => 1,
                'jumlah_hadiah' => 10000000,
                'tanggal_undian' => Carbon::now()->subDays(5),
                'status' => 'pending',
                'catatan' => 'Pemenang kloter diamond periode 1'
            ],
            [
                'nama_pemenang' => 'Maya Sari',
                'email_pemenang' => 'maya.sari@email.com',
                'no_telepon' => '08678901234',
                'kloter_name' => 'Kloter Perak B',
                'periode' => 4,
                'jumlah_hadiah' => 3000000,
                'tanggal_undian' => Carbon::now()->subDays(2),
                'status' => 'paid',
                'catatan' => 'Pembayaran sudah selesai'
            ]
        ];

        foreach ($winners as $winner) {
            Winner::create($winner);
        }
    }
}