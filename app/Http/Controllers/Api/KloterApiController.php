<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kloter;
use App\Models\KloterMember;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class KloterApiController extends Controller
{
    public function show($id): JsonResponse
    {
        try {
            $kloter = Kloter::with(['members', 'rules'])->findOrFail($id);
            
            return response()->json([
                'id' => $kloter->id,
                'name' => $kloter->name,
                'description' => $kloter->description,
                'category' => $kloter->category,
                'nominal' => $kloter->nominal,
                'formatted_nominal' => $kloter->formatted_nominal,
                'admin_fee_amount' => $kloter->admin_fee_amount,
                'formatted_admin_fee' => $kloter->formatted_admin_fee,
                'admin_fee_percentage' => $kloter->admin_fee_percentage,
                'total_monthly_payment' => $kloter->total_monthly_payment,
                'formatted_total_payment' => $kloter->formatted_total_payment,
                'total_slots' => $kloter->total_slots,
                'filled_slots' => $kloter->filled_slots,
                'remaining_slots' => $kloter->remaining_slots,
                'progress_percentage' => $kloter->progress_percentage,
                'status' => $kloter->status,
                'duration_value' => $kloter->duration_value,
                'duration_unit' => $kloter->duration_unit,
                'manager_name' => $kloter->manager_name,
                'payment_schedule' => $kloter->payment_schedule,
                'draw_schedule' => $kloter->draw_schedule,
                'start_date' => $kloter->start_date?->format('Y-m-d'),
                'remaining_days' => $kloter->remaining_days
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kloter tidak ditemukan'
            ], 404);
        }
    }

    public function join(Request $request, $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'member_name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20'
            ]);

            $kloter = Kloter::findOrFail($id);
            
            // Check if kloter is available for joining
            if ($kloter->status !== 'open') {
                return response()->json([
                    'success' => false,
                    'message' => 'Kloter tidak tersedia untuk bergabung'
                ], 400);
            }

            if ($kloter->filled_slots >= $kloter->total_slots) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kloter sudah penuh'
                ], 400);
            }

            // Check if phone number already exists in this kloter
            $existingMember = KloterMember::where('kloter_id', $kloter->id)
                ->where('phone_number', $validated['phone_number'])
                ->first();
                
            if ($existingMember) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor WhatsApp sudah terdaftar di kloter ini'
                ], 400);
            }

            // Get next available slot
            $nextSlot = $kloter->filled_slots + 1;

            // Create new member
            $member = KloterMember::create([
                'kloter_id' => $kloter->id,
                'member_name' => $validated['member_name'],
                'slot_number' => $nextSlot,
                'join_date' => Carbon::now()->toDateString(),
                'phone_number' => $validated['phone_number'],
                'status' => 'active'
            ]);

            // Update kloter filled slots
            $kloter->increment('filled_slots');

            // Check if kloter is now full
            if ($kloter->filled_slots >= $kloter->total_slots) {
                $kloter->update(['status' => 'full']);
            }

            // Generate payment records for the new member
            $this->generatePaymentRecords($kloter, $member);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil bergabung dengan kloter',
                'member' => [
                    'id' => $member->id,
                    'name' => $member->member_name,
                    'slot_number' => $member->slot_number,
                    'join_date' => $member->join_date->format('d F Y')
                ],
                'kloter' => [
                    'filled_slots' => $kloter->filled_slots,
                    'remaining_slots' => $kloter->total_slots - $kloter->filled_slots,
                    'progress_percentage' => round(($kloter->filled_slots / $kloter->total_slots) * 100),
                    'status' => $kloter->status
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    private function generatePaymentRecords(Kloter $kloter, KloterMember $member)
    {
        // Generate payment records for each period
        $startDate = Carbon::parse($kloter->start_date);
        
        for ($period = 1; $period <= $kloter->total_slots; $period++) {
            $dueDate = $startDate->copy();
            
            // Calculate due date based on duration unit
            switch ($kloter->duration_unit) {
                case 'hari':
                    $dueDate->addDays($period - 1);
                    break;
                case 'minggu':
                    $dueDate->addWeeks($period - 1);
                    break;
                case 'bulan':
                    $dueDate->addMonths($period - 1);
                    break;
            }

            \App\Models\KloterPayment::create([
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

public function joinKloter(Request $request)
{
    $request->validate([
        'kloter_id' => 'required|exists:kloters,id',
        'slot_number' => 'required|integer|between:1,12',
        'user_id' => 'required|exists:users,id'
    ]);

    $kloter = Kloter::findOrFail($request->kloter_id);
    if ($kloter->filled_slots >= $kloter->total_slots) {
        return response()->json(['error' => 'Kloter sudah penuh'], 400);
    }

    if (KloterMember::where('kloter_id', $request->kloter_id)
        ->where('slot_number', $request->slot_number)
        ->exists()) {
        return response()->json(['error' => 'Slot sudah diambil'], 400);
    }

    $member = KloterMember::create([
        'kloter_id' => $request->kloter_id,
        'user_id' => $request->user_id,
        'slot_number' => $request->slot_number,
        'status' => 'pending',
        'payment_status' => 'pending'
    ]);

    // Notifikasi admin (misal via email atau dashboard)
    return response()->json(['message' => 'Permintaan berhasil dikirim, menunggu verifikasi admin'], 201);
}
}