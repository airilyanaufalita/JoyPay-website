<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kloter;
use App\Models\KloterRule;
use App\Models\KloterMember;
use App\Models\User;

class KloterSeeder extends Seeder
{
    public function run()
    {
        $klotersData = [
            [
                'id' => 1,
                'name' => 'Arisan Berkah Bulanan',
                'description' => 'Arisan bulanan dengan sistem undian fair dan transparan',
                'category' => 'bulanan',
                'nominal' => 500000,
                'duration_value' => 12,
                'duration_unit' => 'bulan',
                'total_slots' => 12,
                'filled_slots' => 8,
                'admin_fee_percentage' => 2,
                'admin_fee_amount' => 10000,
                'status' => 'open',
                'payment_schedule' => 'Setiap tanggal 5',
                'draw_schedule' => 'Setiap tanggal 10',
                'start_date' => '2024-09-15',
                'current_period' => 0,
                'manager_name' => 'Siti Nurhaliza',
                'payment_method' => 'Transfer Bank',
            ],
            [
                'id' => 2,
                'name' => 'Arisan Mingguan Cepat',
                'description' => 'Arisan mingguan untuk kebutuhan mendesak',
                'category' => 'mingguan',
                'nominal' => 200000,
                'duration_value' => 8,
                'duration_unit' => 'minggu',
                'total_slots' => 8,
                'filled_slots' => 5,
                'admin_fee_percentage' => 2.5,
                'admin_fee_amount' => 5000,
                'status' => 'open',
                'payment_schedule' => 'Setiap Senin',
                'draw_schedule' => 'Setiap Jumat',
                'start_date' => '2024-09-16',
                'current_period' => 0,
                'manager_name' => 'Budi Santoso',
                'payment_method' => 'Transfer Bank',
            ],
            [
                'id' => 3,
                'name' => 'Arisan Harian Express',
                'description' => 'Arisan harian untuk cash flow harian',
                'category' => 'harian',
                'nominal' => 50000,
                'duration_value' => 7,
                'duration_unit' => 'hari',
                'total_slots' => 7,
                'filled_slots' => 7,
                'admin_fee_percentage' => 5,
                'admin_fee_amount' => 2500,
                'status' => 'running',
                'payment_schedule' => 'Setiap hari jam 08:00',
                'draw_schedule' => 'Setiap hari jam 20:00',
                'start_date' => '2024-09-01',
                'current_period' => 3,
                'manager_name' => 'Andi Wijaya',
                'payment_method' => 'E-Wallet',
            ],
            // ... tambahkan kloter lainnya sesuai kebutuhan
        ];

        foreach ($klotersData as $data) {
            $kloter = Kloter::updateOrCreate(
                ['id' => $data['id']], 
                $data
            );
            
            // Add default rules for each kloter
            if ($kloter->rules()->count() == 0) {
                $defaultRules = [
                    'Pembayaran kontribusi dilakukan maksimal H-3 dari jadwal undian',
                    'Undian dilakukan secara digital dengan sistem random yang transparan',
                    'Pemenang undian akan menerima dana dalam 1x24 jam',
                    'Keterlambatan pembayaran 3x berturut-turut akan dikeluarkan dari kloter',
                    'Semua transaksi dijamin aman dengan sistem escrow JoyPay',
                    'Member wajib bergabung di grup WhatsApp untuk koordinasi',
                    'Tidak diperkenankan keluar sebelum mendapat giliran arisan'
                ];
                
                foreach ($defaultRules as $rule) {
                    KloterRule::create([
                        'kloter_id' => $kloter->id,
                        'rule_text' => $rule
                    ]);
                }
            }

            // Create sample members for kloter with filled_slots > 0
            if ($kloter->filled_slots > 0 && $kloter->members()->count() == 0) {
                $users = User::limit($kloter->filled_slots)->get();
                
                foreach ($users as $index => $user) {
                    if ($index < $kloter->filled_slots) {
                        KloterMember::create([
                            'kloter_id' => $kloter->id,
                            'user_id' => $user->id,
                            'joined_at' => now()->subDays(rand(1, 30)),
                            'status' => 'active'
                        ]);
                    }
                }
            }
        }
    }
}