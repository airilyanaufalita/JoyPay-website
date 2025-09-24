<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KloterMember;
use App\Models\Kloter;
use App\Models\User;

class KloterMemberSeeder extends Seeder
{
    public function run()
    {
        // Get existing kloters and users
        $kloters = Kloter::all();
        $users = User::where('status', 'approved')->limit(30)->get();

        if ($kloters->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Tidak ada kloter atau user untuk seeder. Jalankan UserSeeder dan KloterSeeder terlebih dahulu.');
            return;
        }

        $memberData = [];
        
        foreach ($kloters as $kloter) {
            // Untuk setiap kloter, buat beberapa member dengan status berbeda
            $usedSlots = [];
            $usedUsers = [];
            $memberCount = 0;
            
            // Buat member maksimal 80% dari total slots
            $maxMembers = min(ceil($kloter->total_slots * 0.8), $users->count());
            
            foreach ($users as $user) {
                // Stop jika sudah mencapai batas atau sudah cukup member
                if ($memberCount >= $maxMembers) {
                    break;
                }

                // Skip jika user sudah dipakai untuk kloter ini
                if (in_array($user->id, $usedUsers)) {
                    continue;
                }

                // Generate slot number yang belum dipakai
                do {
                    $slotNumber = rand(1, $kloter->total_slots);
                } while (in_array($slotNumber, $usedSlots));
                
                $usedSlots[] = $slotNumber;
                $usedUsers[] = $user->id;

                // Calculate monthly payment berdasarkan slot dan logika kloter bergabung
                $baseAmount = $kloter->nominal / $kloter->total_slots;
                $adjustment = ($kloter->total_slots - $slotNumber) * ($baseAmount * 0.05);
                $monthlyPayment = round($baseAmount + $adjustment);

                // Tentukan status berdasarkan index - lebih banyak pending untuk testing
                $status = match($memberCount % 5) {
                    0, 1 => 'pending',    // 40% pending
                    2 => 'approved',      // 20% approved
                    3 => 'approved',      // 20% approved (double)
                    4 => 'rejected',      // 20% rejected
                    default => 'pending'
                };

                // Tentukan tanggal
                $joinedAt = now()->subDays(rand(1, 30));
                $verifiedAt = in_array($status, ['approved', 'rejected']) ? $joinedAt->copy()->addHours(rand(1, 48)) : null;

                $memberData[] = [
                    'kloter_id' => $kloter->id,
                    'user_id' => $user->id,
                    'slot_number' => $slotNumber,
                    'monthly_payment' => $monthlyPayment,
                    'status' => $status,
                    'joined_at' => $joinedAt,
                    'verified_at' => $verifiedAt,
                    'verified_by' => $verifiedAt ? 1 : null, // Asumsi admin ID 1 ada
                    'payment_status' => 'pending',
                    'total_paid' => 0,
                    'rejection_note' => $status === 'rejected' ? $this->getRandomRejectionNote() : null,
                    'created_at' => $joinedAt,
                    'updated_at' => $verifiedAt ?? $joinedAt,
                ];

                $memberCount++;
            }

            // Update filled_slots di kloter berdasarkan member yang approved/active
            $approvedCount = collect($memberData)
                ->where('kloter_id', $kloter->id)
                ->whereIn('status', ['approved', 'active'])
                ->count();
            
            $kloter->update(['filled_slots' => $approvedCount]);
        }

        // Batch insert untuk performance
        foreach (array_chunk($memberData, 100) as $chunk) {
            KloterMember::insert($chunk);
        }

        $this->command->info('KloterMember seeder completed. Total members created: ' . count($memberData));
        
        // Show statistics
        $totalMembers = count($memberData);
        $pendingCount = collect($memberData)->where('status', 'pending')->count();
        $approvedCount = collect($memberData)->where('status', 'approved')->count();
        $rejectedCount = collect($memberData)->where('status', 'rejected')->count();

        $this->command->info("Statistics:");
        $this->command->info("- Total Members: {$totalMembers}");
        $this->command->info("- Pending: {$pendingCount}");
        $this->command->info("- Approved: {$approvedCount}");
        $this->command->info("- Rejected: {$rejectedCount}");
    }

    private function getRandomRejectionNote()
    {
        $notes = [
            'Data pendaftaran kurang lengkap',
            'Belum memenuhi syarat minimum bergabung',
            'Slot yang dipilih tidak sesuai dengan kemampuan finansial',
            'Perlu verifikasi ulang dokumen pendukung',
            'Riwayat pembayaran arisan sebelumnya kurang baik',
            'Belum ada konfirmasi dari penjamin',
            'Perlu melengkapi data bank yang valid'
        ];

        return $notes[array_rand($notes)];
    }
}