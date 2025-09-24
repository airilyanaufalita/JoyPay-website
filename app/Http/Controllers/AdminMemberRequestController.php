<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Kloter;
use App\Models\KloterMember;
use App\Models\KloterMemberRequest;

class AdminMemberRequestController extends Controller
{
    /**
     * Display list of pending member requests for admin verification
     */
    public function index(Request $request)
    {
        try {
            $search = $request->get('search');
            $status = $request->get('status');
            $kloter_id = $request->get('kloter_id');

            $query = KloterMemberRequest::with(['user', 'kloter']);

            // Apply filters
            if ($search) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
                });
            }

            if ($status) {
                $query->where('status', $status);
            }

            if ($kloter_id) {
                $query->where('kloter_id', $kloter_id);
            }

            $pendingJoins = $query->orderBy('joined_at', 'desc')->paginate(10);

            // Get kloters for filter dropdown
            $kloters = Kloter::orderBy('name')->get();

            // Get statistics
            $pendingCount = KloterMemberRequest::where('status', 'pending')->count();
            $approvedCount = KloterMember::where('status', 'approved')->count();
            $rejectedCount = KloterMemberRequest::where('status', 'rejected')->count();
            $totalRequests = KloterMemberRequest::count();

            return view('admin.konfirmasi-masuk-kloter', compact(
                'pendingJoins', 'kloters', 'pendingCount', 'approvedCount', 'rejectedCount', 'totalRequests'
            ));

        } catch (\Exception $e) {
            Log::error('Admin member requests index error: ' . $e->getMessage());
            return view('admin.konfirmasi-masuk-kloter', [
                'pendingJoins' => collect([]),
                'kloters' => collect([]),
                'pendingCount' => 0,
                'approvedCount' => 0,
                'rejectedCount' => 0,
                'totalRequests' => 0
            ])->with('error', 'Gagal memuat daftar permintaan.');
        }
    }

    /**
     * Approve member request - move to KloterMember table
     */
    public function approve($id)
    {
        Log::info('Approve member request', ['request_id' => $id, 'admin_id' => Auth::id()]);

        try {
            DB::beginTransaction();

            // Get the request
            $request = KloterMemberRequest::with(['user', 'kloter'])->findOrFail($id);

            // Check if request is still pending
            if ($request->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Permintaan sudah diproses sebelumnya'
                ], 400);
            }

            // Check if slot is still available
            $existingMember = KloterMember::where('kloter_id', $request->kloter_id)
                ->where('slot_number', $request->slot_number)
                ->first();

            if ($existingMember) {
                return response()->json([
                    'success' => false,
                    'message' => 'Slot sudah diambil oleh member lain'
                ], 400);
            }

            // Check if user is already member of this kloter
            $existingUserMember = KloterMember::where('kloter_id', $request->kloter_id)
                ->where('user_id', $request->user_id)
                ->first();

            if ($existingUserMember) {
                return response()->json([
                    'success' => false,
                    'message' => 'User sudah menjadi member kloter ini'
                ], 400);
            }

            // Create new member record
            $member = KloterMember::create([
                'kloter_id' => $request->kloter_id,
                'user_id' => $request->user_id,
                'slot_number' => $request->slot_number,
                'monthly_payment' => $request->monthly_payment,
                'joined_at' => $request->joined_at,
                'status' => 'approved',
                'payment_status' => 'pending',
                'total_paid' => 0,
                'verified_at' => now(),
                'verified_by' => Auth::id()
            ]);

            // Update request status
            $request->update([
                'status' => 'approved',
                'verified_at' => now(),
                'verified_by' => Auth::id()
            ]);

            // Update kloter filled_slots
            $kloter = $request->kloter;
            $approvedMembers = KloterMember::where('kloter_id', $kloter->id)
                ->whereIn('status', ['approved', 'active'])
                ->count();
            
            $kloter->filled_slots = $approvedMembers;
            
            // Update kloter status if full
            if ($approvedMembers >= $kloter->total_slots) {
                $kloter->status = 'full';
            }
            
            $kloter->save();

            DB::commit();

            Log::info('Member request approved successfully', [
                'request_id' => $id,
                'member_id' => $member->id,
                'kloter_filled_slots' => $kloter->filled_slots
            ]);

            return response()->json([
                'success' => true,
                'message' => "Permintaan {$request->user->name} untuk bergabung ke {$kloter->name} telah disetujui!"
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollback();
            Log::error('Member request not found', ['request_id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Permintaan tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error approving member request', [
                'request_id' => $id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyetujui permintaan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject member request with reason
     */
    public function reject(Request $request, $id)
    {
        Log::info('Reject member request', ['request_id' => $id, 'admin_id' => Auth::id()]);

        try {
            $request->validate([
                'rejection_note' => 'nullable|string|max:500'
            ]);

            DB::beginTransaction();

            // Get the request
            $memberRequest = KloterMemberRequest::with(['user', 'kloter'])->findOrFail($id);

            // Check if request is still pending
            if ($memberRequest->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Permintaan sudah diproses sebelumnya'
                ], 400);
            }

            // Update request status to rejected
            $memberRequest->update([
                'status' => 'rejected',
                'rejection_note' => $request->input('rejection_note'),
                'verified_at' => now(),
                'verified_by' => Auth::id()
            ]);

            DB::commit();

            Log::info('Member request rejected successfully', [
                'request_id' => $id,
                'rejection_note' => $request->input('rejection_note')
            ]);

            return response()->json([
                'success' => true,
                'message' => "Permintaan {$memberRequest->user->name} untuk bergabung ke {$memberRequest->kloter->name} telah ditolak."
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollback();
            Log::error('Member request not found', ['request_id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Permintaan tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error rejecting member request', [
                'request_id' => $id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menolak permintaan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get detailed information about a member request
     */
    public function detail($id)
    {
        try {
            $memberRequest = KloterMemberRequest::with(['user', 'kloter'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $memberRequest->id,
                    'user' => [
                        'name' => $memberRequest->user->name,
                        'email' => $memberRequest->user->email,
                        'username' => $memberRequest->user->username ?? '-',
                        'phone' => $memberRequest->user->phone ?? '-'
                    ],
                    'kloter' => [
                        'name' => $memberRequest->kloter->name,
                        'nominal' => $memberRequest->kloter->nominal,
                        'duration_value' => $memberRequest->kloter->duration_value,
                        'duration_unit' => $memberRequest->kloter->duration_unit,
                        'total_slots' => $memberRequest->kloter->total_slots,
                        'filled_slots' => $memberRequest->kloter->filled_slots
                    ],
                    'slot_number' => $memberRequest->slot_number,
                    'monthly_payment' => $memberRequest->monthly_payment,
                    'status' => $memberRequest->status,
                    'joined_at' => $memberRequest->joined_at,
                    'verified_at' => $memberRequest->verified_at,
                    'verified_by' => $memberRequest->verified_by,
                    'rejection_note' => $memberRequest->rejection_note
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Member request not found', ['request_id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Permintaan tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error getting member request detail', [
                'request_id' => $id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat detail'
            ], 500);
        }
    }

    /**
     * Get statistics for dashboard
     */
    public function stats()
    {
        try {
            $pendingCount = KloterMemberRequest::where('status', 'pending')->count();
            $approvedCount = KloterMember::where('status', 'approved')->count();
            $rejectedCount = KloterMemberRequest::where('status', 'rejected')->count();
            $totalRequests = KloterMemberRequest::count();

            return response()->json([
                'success' => true,
                'pendingCount' => $pendingCount,
                'approvedCount' => $approvedCount,
                'rejectedCount' => $rejectedCount,
                'totalRequests' => $totalRequests
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting member request stats: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat statistik'
            ], 500);
        }
    }
}