<?php
namespace App\Services;

use App\Models\Kloter;
use App\Models\KloterMember;
use App\Models\KloterPayment;
use Carbon\Carbon;

class KloterService
{
    public function joinKloter(Kloter $kloter, array $memberData): array
    {
        // Validate kloter availability
        if ($kloter->status !== 'open') {
            throw new \Exception('Kloter tidak tersedia untuk bergabung');
        }

        if ($kloter->filled_slots >= $kloter->total_slots) {
            throw new \Exception('Kloter sudah penuh');
        }

        // Check for duplicate phone number
        $existingMember = KloterMember::where('kloter_id', $kloter->id)
            ->where('phone_number', $memberData['phone_number'])
            ->first();
            
        if ($existingMember) {
            throw new \Exception('Nomor WhatsApp sudah terdaftar di kloter ini');
        }

        // Create member
        $member = KloterMember::create([
            'kloter_id' => $kloter->id,
            'member_name' => $memberData['member_name'],
            'slot_number' => $kloter->filled_slots + 1,
            'join_date' => Carbon::now()->toDateString(),
            'phone_number' => $memberData['phone_number'],
            'status' => 'active'
        ]);

        // Update kloter
        $kloter->increment('filled_slots');
        
        if ($kloter->filled_slots >= $kloter->total_slots) {
            $kloter->update(['status' => 'full']);
        }

        // Generate payment records
        $this->generatePaymentRecords($kloter, $member);

        return [
            'member' => $member,
            'kloter' => $kloter->fresh()
        ];
    }

    public function generatePaymentRecords(Kloter $kloter, KloterMember $member): void
    {
        $startDate = Carbon::parse($kloter->start_date);
        
        for ($period = 1; $period <= $kloter->total_slots; $period++) {
            $dueDate = $this->calculateDueDate($startDate, $period, $kloter->duration_unit);

            KloterPayment::create([
                'kloter_id' => $kloter->id,
                'member_id' => $member->id,
                'period' => $period,
                'amount' => $kloter->nominal,
                'admin_fee' => $kloter->admin_fee_amount,
                'total_amount' => $kloter->nominal + $kloter->admin_fee_amount,
                'due_date' => $dueDate->toDateString(),
                'status' => 'pending'
            ]);
        }
    }

    private function calculateDueDate(Carbon $startDate, int $period, string $durationUnit): Carbon
    {
        $dueDate = $startDate->copy();
        
        switch ($durationUnit) {
            case 'hari':
                return $dueDate->addDays($period - 1);
            case 'minggu':
                return $dueDate->addWeeks($period - 1);
            case 'bulan':
                return $dueDate->addMonths($period - 1);
            default:
                return $dueDate;
        }
    }

    public function getKloterStats(): array
    {
        return [
            'total_active' => Kloter::whereIn('status', ['open', 'running'])->count(),
            'total_open' => Kloter::where('status', 'open')->count(),
            'total_members' => KloterMember::where('status', 'active')->count(),
            'total_volume' => Kloter::sum('nominal')
        ];
    }
}